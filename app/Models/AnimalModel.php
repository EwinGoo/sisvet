<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalModel extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'animales';
    protected $primaryKey = 'id_animal';
    protected $fillable = ['animal', 'descripcion'];
    protected $guarded = [];
    public $timestamps = false;
    // protected $dates = ['deleted_at'];
}
