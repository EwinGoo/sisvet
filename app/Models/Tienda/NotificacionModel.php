<?php

namespace App\Models\Tienda;

use App\Models\Tienda\ProductoModel;
use App\Models\UsuarioModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionModel extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';
    public $timestamps = false;
    protected $fillable = [
        'id_usuario',
        'id_producto',
        'titulo',
        'mensaje',
        'leida',
        'tipo'
    ];
    
    public function producto()
    {
        return $this->belongsTo(ProductoModel::class, 'id_producto');
    }
    
    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'id_usuario');
    }
}