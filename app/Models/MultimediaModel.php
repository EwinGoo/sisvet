<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class MultimediaModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'multimedia';
    protected $primaryKey = 'id_multimedia';
    protected $fillable = ['nombre_mascota', 'id_propietario', 'vacunas', 'genero', 'color', 'edad', 'id_animal', 'id_raza'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];
}
