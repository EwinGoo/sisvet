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
    protected $fillable = ['nombre_mascota', 'id_propietario', 'vacunas', 'genero', 'color', 'years', 'meses', 'id_animal', 'id_raza','id_multimedia','peso'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public static function getMascota()
    {
        $results = self::select('*','mascotas.id_mascota')
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
        $results = self::select('*')
            ->selectRaw("CONCAT_WS(' ', p.nombre, p.paterno, IFNULL(p.materno, '')) as nombre_completo")
            ->join('propietarios as p', 'p.id_propietario', '=', 'mascotas.id_propietario')
            ->join('animales as a', 'a.id_animal', '=', 'mascotas.id_animal')
            ->where('id_mascota', $id)
            // ->orderBy('desc', 'id_historial')
            ->first();
        return $results;
    }
}
