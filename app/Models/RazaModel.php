<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class RazaModel extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'razas';
    protected $primaryKey = 'id_raza';
    protected $fillable = ['raza', 'descripcion', 'id_animal'];
    protected $guarded = [];
    public $timestamps = false;
    // protected $dates = ['deleted_at'];
}
