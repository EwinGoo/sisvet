<?php

namespace App\Models\Tienda;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ProductoModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $fillable = ['id_usuario', 'descripcion', 'nombre_producto', 'id_categoria', 'id_proveedor', 'precio', 'fecha_vencimiento', 'codigo_barras', 'id_multimedia', 'cantidad'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public function categoria()
    {
        return $this->belongsTo(CategoriaModel::class, 'id_categoria');
    }
    public function compras()
    {
        return $this->hasMany(CompraModel::class, 'id_producto');
    }
    public function ventas()
    {
        return $this->hasMany(DetalleVentaModel::class, 'id_producto');
    }



    public static function getProducto(?string $searchTerm = null)
    {
        try {
            $query = static::select([
                'productos.id_producto',
                'productos.nombre_producto',
                'productos.descripcion',
                'm.ruta_archivo',
                'categorias.nombre_categoria',
                'categorias.id_categoria',
                DB::raw('(SELECT compras.precio_compra
                         FROM compras
                         WHERE compras.id_producto = productos.id_producto
                         ORDER BY compras.fecha_compra DESC, compras.id_compra DESC
                         LIMIT 1) as precio_compra_actual'),
                DB::raw('(SELECT compras.precio_venta
                         FROM compras
                         WHERE compras.id_producto = productos.id_producto
                         ORDER BY compras.fecha_compra DESC, compras.id_compra DESC
                         LIMIT 1) as precio_venta_actual'),
                DB::raw('(SELECT SUM(compras.cantidad_compra) -
                         IFNULL((SELECT SUM(detalles_venta.cantidad)
                                FROM detalles_venta
                                WHERE detalles_venta.id_producto = productos.id_producto), 0)
                         FROM compras
                         WHERE compras.id_producto = productos.id_producto) as stock_disponible')
            ])
                ->leftJoin('multimedia as m', 'm.id_multimedia', '=', 'productos.id_multimedia')
                ->leftJoin('categorias', 'categorias.id_categoria', '=', 'productos.id_categoria');

            // Aplicar filtros de búsqueda si hay término
            if ($searchTerm) {
                $searchTerm = '%' . trim($searchTerm) . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('productos.id_producto', 'LIKE', $searchTerm)
                        ->orWhere('productos.nombre_producto', 'LIKE', $searchTerm);
                });
            }

            return $query->orderBy('productos.nombre_producto', 'asc')->get();
        } catch (QueryException $e) {
            Log::error("Error en consulta SQL al buscar productos", [
                'error' => $e->getMessage(),
                'searchTerm' => $searchTerm,
                'code' => $e->getCode()
            ]);
            throw new \Exception("Error al realizar la búsqueda de productos: " . $e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            Log::error("Error general al buscar productos", [
                'error' => $e->getMessage(),
                'searchTerm' => $searchTerm,
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception("Error inesperado al procesar la búsqueda de productos", 500, $e);
        }
    }

    public static function getProductosConStock()
    {
        return static::select([
            'productos.id_producto',
            'productos.nombre_producto',
            'productos.descripcion',
            DB::raw('SUM(compras.cantidad_compra) as total_compras'),
            DB::raw('COALESCE(SUM(detalle_ventas.cantidad), 0) as total_ventas'),
            DB::raw('GREATEST(0, SUM(compras.cantidad_compra) - COALESCE(SUM(detalle_ventas.cantidad), 0)) as cantidad_disponible')
        ])
            ->join('productos', 'productos.id_producto', '=', 'compras.id_producto')
            ->leftJoin('detalle_ventas', 'detalle_ventas.id_producto', '=', 'compras.id_producto')
            ->groupBy('productos.id_producto', 'productos.nombre_producto', 'productos.descripcion')
            ->orderBy('productos.nombre_producto')
            ->get();
    }

    // Relación con compras (para obtener la última)
    public function ultimaCompra()
    {
        return $this->hasOne(CompraModel::class, 'id_producto')
            ->latest('fecha_compra')
            ->latest('id_compra');
    }

    // Accessor para stock disponible
    protected function cantidadDisponible(): Attribute
    {
        return Attribute::make(
            get: function () {
                $totalCompras = $this->compras()->sum('cantidad_compra');
                $totalVentas = $this->ventas()->sum('cantidad');
                return max(0, $totalCompras - $totalVentas);
            }
        );
    }
}
