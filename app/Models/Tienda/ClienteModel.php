<?php

namespace App\Models\Tienda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ClienteModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';
    protected $fillable = ['id_usuario','ci', 'nombre', 'paterno', 'materno', 'celular', 'direccion'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    /**
     * Obtiene los clientes con filtrado opcional por término de búsqueda
     */
    public static function getCliente(?string $searchTerm = null)
    {
        try {
            $query = static::select([
                'id_cliente',
                'id_usuario',
                'ci',
                'nombre',
                'paterno',
                'materno',
                'celular',
                'direccion'
            ])->selectRaw("CONCAT_WS(' ', nombre, paterno, IFNULL(materno, '')) as nombre_completo");

            // Si hay término de búsqueda, aplicar filtros
            if ($searchTerm) {
                $searchTerm = '%' . trim($searchTerm) . '%';
                
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('ci', 'LIKE', $searchTerm)
                      ->orWhere('nombre', 'LIKE', $searchTerm)
                      ->orWhere('paterno', 'LIKE', $searchTerm)
                      ->orWhere('materno', 'LIKE', $searchTerm)
                    //   ->orWhere('celular', 'LIKE', $searchTerm)
                    //   ->orWhere('direccion', 'LIKE', $searchTerm)
                      ->orWhereRaw("CONCAT_WS(' ', nombre, paterno, IFNULL(materno, '')) LIKE ?", [$searchTerm]);
                });
            }

            return $query->orderBy('id_cliente', 'desc')
                        ->get();

        } catch (QueryException $e) {
            Log::error("Error en consulta SQL al buscar clientes", [
                'error' => $e->getMessage(),
                'searchTerm' => $searchTerm,
                'code' => $e->getCode()
            ]);
            throw new \Exception("Error al realizar la búsqueda de clientes: " . $e->getMessage(), $e->getCode(), $e);
            
        } catch (\Exception $e) {
            Log::error("Error general al buscar clientes", [
                'error' => $e->getMessage(),
                'searchTerm' => $searchTerm,
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception("Error inesperado al procesar la búsqueda de clientes", 500, $e);
        }
    }

    /**
     * Busca clientes para autocompletado
     *
     */
    public static function searchForAutocomplete(string $term, int $limit = 10)
    {
        try {
            return static::select([
                'id_cliente as id',
                'ci as code',
                DB::raw("CONCAT_WS(' ', nombre, paterno, IFNULL(materno, '')) as name"),
                'celular'
            ])
            ->where(function ($query) use ($term) {
                $term = '%' . trim($term) . '%';
                $query->where('ci', 'LIKE', $term)
                      ->orWhere(DB::raw("CONCAT_WS(' ', nombre, paterno, IFNULL(materno, ''))"), 'LIKE', $term);
            })
            ->limit($limit)
            ->get()
            ->map(function ($cliente) {
                return [
                    'id' => $cliente->id,
                    'code' => $cliente->code,
                    'name' => $cliente->name,
                    'celular' => $cliente->celular,
                    'label' => "{$cliente->code} - {$cliente->name}"
                ];
            })
            ->toArray();

        } catch (\Exception $e) {
            Log::error("Error en autocompletado de clientes", [
                'error' => $e->getMessage(),
                'term' => $term
            ]);
            throw $e;
        }
    }

}
