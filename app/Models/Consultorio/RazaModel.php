<?php

namespace App\Models\Consultorio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class RazaModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'razas';
    protected $primaryKey = 'id_raza';
    protected $fillable = ['raza', 'descripcion', 'id_animal'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public static function getRazas()
    {
        return self::select('*')
            ->join('animales as a', 'razas.id_animal', '=', 'a.id_animal')
            ->select('razas.*', 'a.animal as nombre_animal')
            ->get();
    }

    public static function getRaza($id)
    {
        return DB::table('razas as r')
            ->join('animales as a', 'r.id_animal', '=', 'a.id_animal')
            ->select('r.*', 'a.animal as nombre_animal')
            ->where('r.id_raza', $id)
            ->first();
    }
}
