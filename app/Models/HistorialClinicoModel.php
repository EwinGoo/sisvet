<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistorialClinicoModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'historial_clinico';
    protected $primaryKey = 'id_historial';
    protected $fillable = ['id_mascota', 'id_usuario', 'anamenesis', 'vacunas', 'ultima_desparasitacion', 'tratamientos_recientes', 'enfermedades_anteriores','estado'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

}
