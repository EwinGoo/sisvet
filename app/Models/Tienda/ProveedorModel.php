<?php

namespace App\Models\Tienda;

use App\Models\UsuarioModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProveedorModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'proveedores';
    protected $primaryKey = 'id_proveedor';
    protected $fillable = [
        'nombre',
        'id_usuario',
        'contacto',
        'celular',
        'correo',
        'direccion'
    ];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'id_usuario');
    }

    public static function getProveedores(?string $searchTerm = null)
    {
        $query = static::select([
            'proveedores.*',
            // 'usuarios.name as nombre_usuario'
        ]);
        // ->leftJoin('usuarios', 'usuarios.id', '=', 'proveedores.id_usuario');

        if ($searchTerm) {
            $searchTerm = '%' . trim($searchTerm) . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('proveedores.nombre', 'LIKE', $searchTerm)
                  ->orWhere('proveedores.contacto', 'LIKE', $searchTerm)
                  ->orWhere('proveedores.correo', 'LIKE', $searchTerm);
            });
        }

        return $query->orderBy('proveedores.nombre', 'asc')->get();
    }
}
