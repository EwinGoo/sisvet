<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsuarioModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'usuario',
        'nombre',
        'paterno',
        'materno',
        'email',
        'password',
        'rol',
        'celular',
        'id_multimedia',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static function getUser($id)
    {
        $results = self::select('*')
            ->leftJoin('multimedia as m', 'usuarios.id_multimedia', '=', 'm.id_multimedia')
            ->leftJoin('roles as r', 'r.id_rol', '=', 'usuarios.id_rol')
            ->where('id_usuario', $id)
            ->first();
        return $results;
    }
    public static function getUsers()
    {
        $results = self::select('usuarios.*', 'm.ruta_archivo', 'r.rol')
            ->leftJoin('multimedia as m', 'usuarios.id_multimedia', '=', 'm.id_multimedia')
            ->leftJoin('roles as r', 'r.id_rol', '=', 'usuarios.id_rol')
            ->get();
        return $results;
    }
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
}
