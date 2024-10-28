<?php

namespace App\Models\Tienda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompraModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'compras';
    protected $primaryKey = 'id_compra';
    protected $fillable = ['id_usuario', 'id_producto', 'fecha_compra', 'fecha_caducidad', 'precio_compra', 'precio_venta', 'cantidad_compra', 'precio_total_compra'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];
}
