<?php

namespace App\Models\Tienda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVentaModel extends Model
{
    use HasFactory;
    protected $table = 'detalles_venta';
    protected $primaryKey = 'id_detalle';
    protected $fillable = ['id_venta', 'id_producto', 'cantidad','precio_unitario','subtotal'];
    protected $guarded = [];
    public $timestamps = false;


}
