<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class MascotaModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'mascotas';
    protected $primaryKey = 'id_mascota';
    protected $fillable = ['nombre_mascota', 'id_propietario', 'vacunas', 'genero', 'color', 'years', 'meses', 'id_animal', 'id_raza', 'id_multimedia', 'peso'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public static function getMascota()
    {
        $results = self::select('*', 'mascotas.id_mascota')
            ->selectRaw("CONCAT_WS(' ', p.nombre, p.paterno, IFNULL(p.materno, '')) as nombre_completo")
            ->selectRaw('hc.id_historial')
            ->leftJoin('propietarios as p', 'p.id_propietario', '=', 'mascotas.id_propietario')
            ->leftJoin('animales as a', 'a.id_animal', '=', 'mascotas.id_animal')
            ->leftJoin('multimedia as m', 'm.id_multimedia', '=', 'mascotas.id_multimedia')
            ->leftJoin('historial_clinico as hc', 'hc.id_mascota', '=', 'mascotas.id_mascota')
            ->orderBy('mascotas.id_mascota', 'desc')
            ->get();

        return $results;
    }
    public static function getFullInformation($id)
    {
        return self::select('mascotas.*','m.ruta_archivo','r.raza','a.animal')
            ->selectRaw("CONCAT_WS(' ', p.nombre, p.paterno, IFNULL(p.materno, '')) as nombre_completo")
            ->selectRaw("CONCAT('VET-', YEAR(mascotas.created_at), '-', LPAD(mascotas.id_mascota, 6, '0')) as registro")
            ->selectRaw("(
            SELECT GROUP_CONCAT(
                CONCAT(
                    '{\"id_vacuna\":\"', v.id_vacuna,
                    '\",\"nombre_vacuna\":\"', tv.nombre_vacuna,
                    '\",\"fecha_aplicacion\":\"', v.fecha, '\"}'
                ) SEPARATOR ','
            )
            FROM vacunas v
            JOIN tipos_vacunas tv ON tv.id_tipo_vacuna = v.id_tipo_vacuna
            WHERE v.id_historial = h.id_historial  -- ¡Filtro clave aquí!
        ) as vacunas")
            ->join('propietarios as p', 'p.id_propietario', '=', 'mascotas.id_propietario')
            ->join('animales as a', 'a.id_animal', '=', 'mascotas.id_animal')
            ->leftJoin('multimedia as m', 'm.id_multimedia', '=', 'mascotas.id_multimedia')
            ->leftJoin('razas as r', 'r.id_animal', '=', 'a.id_animal')
            ->join('historial_clinico as h', 'h.id_mascota', '=', 'mascotas.id_mascota')
            ->where('mascotas.id_mascota', $id)
            ->groupBy('mascotas.id_mascota')
            ->first();
    }
}
