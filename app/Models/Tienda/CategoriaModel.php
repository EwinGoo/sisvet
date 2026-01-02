<?php

namespace App\Models\Tienda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    protected $fillable = ['nombre_categoria','descripcion'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

}
