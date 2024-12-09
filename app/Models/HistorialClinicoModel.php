<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class HistorialClinicoModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'historial_clinico';
    protected $primaryKey = 'id_historial';
    protected $fillable = ['id_mascota', 'id_usuario', 'anamenesis', 'vacunas', 'ultima_desparasitacion', 'tratamientos_recientes', 'enfermedades_anteriores', 'estado'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public static function getAllHistorialMascota($id)
    {
        $results = self::select('*')
            ->where('id_mascota', $id)
            ->orderBy('id_historial', 'desc')
            ->get();
        return $results;
    }
    public static function getHistorialMascota($id)
    {
        $results = self::select('*')
            ->selectRaw("CONCAT_WS(' ', p.nombre, p.paterno, IFNULL(p.materno, '')) as nombre_completo")
            ->join('mascotas as m', 'm.id_mascota', '=', 'historial_clinico.id_mascota')
            ->join('animales as a', 'a.id_animal', '=', 'm.id_animal')
            ->join('propietarios as p', 'p.id_propietario', '=', 'm.id_propietario')
            ->leftJoin('multimedia as mu', 'mu.id_multimedia', '=', 'm.id_multimedia')
            ->where('id_historial', $id)
            ->first();
        return $results;
    }
    public static function getFullDataHistorial($id)
    {
        try {
            // Verificar si el historial existe
            $historial = DB::table('historial_clinico')->where('id_historial', $id)->first();

            if (!$historial) {
                return null;
            }
            return [
                'anamnesis' => $historial,
                'examen' => DB::table('examen_general')->where('id_historial', $id)->get(),
                'sintomas' => DB::table('sintomas')->where('id_historial', $id)->get(),
                'metodos_complementarios' => DB::table('metodos_complementarios')->where('id_historial', $id)->get(),
                'diagnosticos_presuntivos' => DB::table('diagnosticos_presuntivos')->where('id_historial', $id)->get(),
                'diagnosticos_definitivos' => DB::table('diagnosticos_definitivos')->where('id_historial', $id)->get(),
                'tratamiento' => DB::table('tratamiento')->where('id_historial', $id)->get(),
                'evolucion' => DB::table('evolucion')->where('id_historial', $id)->get(),
            ];
        } catch (\Exception $e) {
            Log::error("Error al obtener datos del historial: " . $e->getMessage());
            throw $e;
        }
    }
}
