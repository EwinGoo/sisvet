<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class HistorialClinicoModel extends Model
{
    use SoftDeletes;

    protected $table = 'historial_clinico';
    protected $primaryKey = 'id_historial';

    // Constantes para mapeo de tablas y campos
    const TABLE_MAPPING = [
        'vacunas' => [
            'table' => 'vacunas',
            'id_column' => 'id_vacuna',
            'title' => 'Vacuna',
            'required_fields' => ['fecha', 'id_tipo_vacuna']
        ],
        'examen' => [
            'table' => 'examen_general',
            'id_column' => 'id_examen',
            'title' => 'Examen',
            'required_fields' => ['fecha', 'temperatura', 'frecuencia_cardiaca', 'frecuencia_respiratoria', 'mucosa', 'rc']
        ],
        'sintomas' => [
            'table' => 'sintomas',
            'id_column' => 'id_sintoma',
            'title' => 'Síntomas',
            'required_fields' => ['fecha', 'descripcion']
        ],
        'metodos_complementarios' => [
            'table' => 'metodos_complementarios',
            'id_column' => 'id_metodo',
            'title' => 'Método Complementario',
            'required_fields' => ['examen', 'resultados']
        ],
        'diagnosticos_presuntivos' => [
            'table' => 'diagnosticos_presuntivos',
            'id_column' => 'id_diagnostico_presuntivo',
            'title' => 'Diagnóstico Presuntivo',
            'required_fields' => ['fecha', 'descripcion']
        ],
        'diagnosticos_definitivos' => [
            'table' => 'diagnosticos_definitivos',
            'id_column' => 'id_diagnostico_definitivo',
            'title' => 'Diagnóstico Definitivo',
            'required_fields' => ['fecha', 'descripcion']
        ],
        'tratamiento' => [
            'table' => 'tratamiento',
            'id_column' => 'id_tratamiento',
            'title' => 'Tratamiento',
            'required_fields' => ['fecha', 'descripcion']
        ],
        'evolucion' => [
            'table' => 'evolucion',
            'id_column' => 'id_evolucion',
            'title' => 'Evolución',
            'required_fields' => ['fecha_hora', 'descripcion']
        ]
    ];

    protected $fillable = [
        'id_mascota',
        'id_usuario',
        'anamenesis',
        'vacunas',
        'ultima_desparasitacion',
        'tratamientos_recientes',
        'enfermedades_anteriores',
        'estado'
    ];

    public $timestamps = true;
    protected $dates = ['deleted_at'];

    /**
     * Obtiene la información detallada del historial
     */
    public static function getHistorial($id)
    {
        return self::select('*')
            ->selectRaw("CONCAT_WS(' ', p.nombre, p.paterno, IFNULL(p.materno, '')) as nombre_completo")
            ->join('mascotas as m', 'm.id_mascota', '=', 'historial_clinico.id_mascota')
            ->join('animales as a', 'a.id_animal', '=', 'm.id_animal')
            ->join('propietarios as p', 'p.id_propietario', '=', 'm.id_propietario')
            ->leftJoin('multimedia as mu', 'mu.id_multimedia', '=', 'm.id_multimedia')
            ->where('id_historial', $id)
            ->first();
    }

    /**
     * Obtiene datos del historial según la opción especificada
     */
    public static function getDataHistorial($id, $option = null)
    {
        try {
            $historial = DB::table('historial_clinico')
                ->select('historial_clinico.*', 'm.id_animal')
                ->join('mascotas as m', 'm.id_mascota', '=', 'historial_clinico.id_mascota')
                ->where('id_historial', $id)
                ->first();

            if (!$historial) {
                return null;
            }

            if ($option) {
                if (!isset(self::TABLE_MAPPING[$option])) {
                    throw new \Exception("Opción inválida: $option");
                }
                return [
                    $option => DB::table(self::TABLE_MAPPING[$option]['table'])
                        ->where('id_historial', $id)
                        ->get()
                ];
            }

            // 'tipos_vacunas' => DB::table('tipos_vacunas as tv')
            //             ->select('v.id_vacuna', 'v.id_tipo_vacuna', 'tv.nombre_vacuna', 'tv.id_animal')
            //             ->join('tipos_vacunas as tv', 'tv.id_tipo_vacuna', '=', 'v.id_tipo_vacuna')
            //             ->get()
            if (request()->ajax()) {
                $fullData = [
                    'anamnesis' => $historial,
                    'tipos_vacunas' => DB::table('tipos_vacunas')->where('id_animal', $historial->id_animal)->get()
                ];
                foreach (self::TABLE_MAPPING as $key => $mapping) {
                    $query = DB::table($mapping['table'])->where('id_historial', $id);

                    if ($key === 'vacunas') {
                        $query->join('tipos_vacunas as tv', $mapping['table'] . '.id_tipo_vacuna', '=', 'tv.id_tipo_vacuna')
                            ->select($mapping['table'] . '.*', 'tv.nombre_vacuna');
                    }

                    $fullData[$key] =  $query->get();
                }
                return $fullData;
            }

            return ['anamnesis' => $historial];
        } catch (\Exception $e) {
            Log::error("Error al obtener datos del historial: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Guarda o actualiza datos en la tabla correspondiente
     */
    public static function handleHistorialData($data, $option)
    {
        if (!isset(self::TABLE_MAPPING[$option])) {
            throw new \Exception("Opción de historial no válida");
        }

        $mapping = self::TABLE_MAPPING[$option];
        $fields = array_merge(
            ['id_historial' => $data['id_historial']],
            $data
        );
        // dd($fields);

        try {
            // $id = DB::table($mapping['table'])->insertGetId($fields);
            // return DB::table($mapping['table'])
            //     ->where($mapping['id_column'], $id)
            //     ->first();
            $id = DB::table($mapping['table'])->insertGetId($fields);
            return DB::table($mapping['table'])
                ->when($option === 'vacunas', function ($query) use ($mapping) {
                    return $query->join('tipos_vacunas as tv', $mapping['table'] . '.id_tipo_vacuna', '=', 'tv.id_tipo_vacuna')
                        ->select($mapping['table'] . '.*', 'tv.nombre_vacuna');
                })
                ->where($mapping['id_column'], $id)
                ->first();
        } catch (\Exception $e) {
            Log::error("Error al guardar {$mapping['title']}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro del historial
     */
    public static function deleteHistorialData($option, $id)
    {

        // dd($option,$id);
        if (!isset(self::TABLE_MAPPING[$option])) {
            throw new \Exception("Opción de historial no válida");
        }

        $mapping = self::TABLE_MAPPING[$option];

        try {
            $deleted = DB::table($mapping['table'])
                ->where($mapping['id_column'], $id)
                ->delete();

            if (!$deleted) {
                throw new \Exception("Registro no encontrado");
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Error al eliminar {$mapping['title']}: " . $e->getMessage());
            throw $e;
        }
    }
}
