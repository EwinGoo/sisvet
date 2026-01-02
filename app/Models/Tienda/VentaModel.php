<?php

namespace App\Models\Tienda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class VentaModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    protected $fillable = ['id_usuario', 'id_cliente','fecha_venta', 'total_venta'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];


}
