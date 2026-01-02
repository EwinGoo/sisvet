<?php

namespace App\Models\Tienda;

use App\Models\Tienda\ProductoModel;
use App\Models\UsuarioModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class CompraModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'compras';
    protected $primaryKey = 'id_compra';
    protected $fillable = [
        'id_proveedor',
        'id_usuario',
        'id_producto',
        'fecha_compra',
        'fecha_caducidad',
        'precio_compra',
        'precio_venta',
        'cantidad_compra',
        'precio_total_compra',
    ];

    protected $casts = [
        'fecha_compra' => 'date',
        'fecha_caducidad' => 'date',
    ];

    public $timestamps = true;
    protected $dates = ['deleted_at'];

    // Relaciones
    public function proveedor()
    {
        // return $this->belongsTo(ProveedorModel::class, 'id_proveedor');
    }

    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'id_usuario');
    }

    public function producto()
    {
        return $this->belongsTo(ProductoModel::class, 'id_producto');
    }

    public function ventas()
    {
        return $this->hasMany(DetalleVentaModel::class, 'id_producto', 'id_producto');
    }

    // Método para obtener compras con joins
    public static function getCompras()
    {
        try {
            return static::select([
                'compras.id_compra',
                'compras.fecha_compra',
                'compras.cantidad_compra',
                'compras.precio_total_compra',
                'compras.fecha_caducidad',
                'productos.nombre_producto as producto',
                'productos.id_producto',
                'proveedores.nombre as proveedor',
                DB::raw("CONCAT_WS(' ', usuarios.nombre, usuarios.paterno) as usuario"),
            ])
                ->join('productos', 'productos.id_producto', '=', 'compras.id_producto')
                ->leftjoin('proveedores', 'proveedores.id_proveedor', '=', 'compras.id_proveedor')
                ->join('usuarios', 'usuarios.id_usuario', '=', 'compras.id_usuario')
                ->orderBy('compras.fecha_compra', 'desc')
                ->get();
        } catch (QueryException $e) {
            Log::error("Error al obtener compras: " . $e->getMessage());
            throw new \Exception("Error en la consulta de compras");
        }
    }

    public function getFechaCompraAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    // Formatear fecha_caducidad al formato DD-MM-YYYY
    public function getFechaCaducidadAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    protected function cantidadDisponible(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Suma TODAS las compras de este producto
                $totalCompras = self::where('id_producto', $this->id_producto)
                    ->sum('cantidad_compra');

                // Suma TODAS las ventas de este producto
                $totalVentas = DetalleVentaModel::where('id_producto', $this->id_producto)
                    ->sum('cantidad');

                return max(0, $totalCompras - $totalVentas);
            }
        );
    }
}
