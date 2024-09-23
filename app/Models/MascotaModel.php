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
    protected $fillable = ['nombre_mascota','id_propietario', 'vacunas', 'genero', 'color','edad'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    
    public static function getMascota()
{
    $results = self::join('propietarios as p', 'p.id_propietario', '=', 'mascotas.id_propietario')
    ->select('mascotas.nombre_mascota','mascotas.id_mascota','p.id_propietario')
        ->selectRaw("CONCAT_WS(' ', p.nombre, p.paterno, IFNULL(p.materno, '')) as nombre_completo")
        ->get();
    
    return $results;
}

}