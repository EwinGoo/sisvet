<?php

namespace App\Models\Tienda;

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

    public static function getProducto(?string $searchTerm = null)
    {
        try {
            $query = static::select([
                'id_producto',
                'nombre_producto',
                'descripcion',
                'id_categoria',
                'id_proveedor',
                'precio',
                'fecha_vencimiento',
                'cantidad',
                'codigo_barras',
                'm.ruta_archivo'
            ]);

            // Si hay término de búsqueda, aplicar filtros
            if ($searchTerm) {
                $searchTerm = '%' . trim($searchTerm) . '%';

                $query->where(function ($q) use ($searchTerm) {
                    $q->where('id_producto', 'LIKE', $searchTerm)
                        ->orWhere('nombre_producto', 'LIKE', $searchTerm)
                        ->orWhere('fecha_vencimiento', 'LIKE', $searchTerm);
                    //   ->orWhere('celular', 'LIKE', $searchTerm)
                    //   ->orWhere('direccion', 'LIKE', $searchTerm)
                });
            }
            $result = $query->leftJoin('multimedia as m', 'm.id_multimedia', '=', 'productos.id_multimedia')->orderBy('id_producto', 'desc')->get();

            return $result;
        } catch (QueryException $e) {
            Log::error("Error en consulta SQL al buscar produtos", [
                'error' => $e->getMessage(),
                'searchTerm' => $searchTerm,
                'code' => $e->getCode()
            ]);
            throw new \Exception("Error al realizar la búsqueda de produtos: " . $e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            Log::error("Error general al buscar produtos", [
                'error' => $e->getMessage(),
                'searchTerm' => $searchTerm,
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception("Error inesperado al procesar la búsqueda de produtos", 500, $e);
        }
    }
}
