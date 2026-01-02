<?php

namespace App\Models\Consultorio;

use App\Models\MascotaModel;
use App\Models\PropietarioModel;
use App\Models\UsuarioModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class CitaModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'citas';
    protected $primaryKey = 'id_cita';
    protected $fillable = [
        'id_propietario',
        'id_mascota',
        'id_medico', // Cambiado de id_veterinario a id_medico
        'fecha_hora',
        'duracion',
        'tipo_consulta',
        'motivo',
        'estado',
        'motivo_cancelacion',
        'notas'
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public static function getCitas()
    {
        try {
            $query = static::select([
                'citas.id_cita',
                'citas.fecha_hora',
                'citas.tipo_consulta',
                'propietarios.id_propietario',
                'citas.estado',
                'mascotas.nombre_mascota',
                'mascotas.id_mascota',
                'animales.animal as especie',
                'propietarios.celular',
                'propietarios.celular',
                'citas.motivo',
                'citas.notas',
                'citas.duracion',
                DB::raw("CONCAT_WS(' ', usuarios.nombre, usuarios.paterno, IFNULL(usuarios.materno, '')) as nombre_medico"),
                DB::raw("CONCAT_WS(' ', propietarios.nombre, propietarios.paterno, IFNULL(propietarios.materno, '')) as nombre_propietario")
            ])
            ->join('mascotas', 'mascotas.id_mascota', '=', 'citas.id_mascota')
            ->join('propietarios', 'propietarios.id_propietario', '=', 'citas.id_propietario')
            ->leftJoin('animales', 'animales.id_animal', '=', 'mascotas.id_animal')
            ->leftJoin('usuarios', 'usuarios.id_usuario', '=', 'citas.id_medico')
            ->where('citas.id_medico', auth()->id()); // Solo citas del médico logueado

            return $query->orderBy('citas.fecha_hora', 'desc')->get();

        } catch (QueryException $e) {
            Log::error("Error en consulta SQL al buscar citas", [
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
            throw new \Exception("Error al realizar la búsqueda de citas: " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function propietario()
    {
        return $this->belongsTo(PropietarioModel::class, 'id_propietario');
    }

    public function mascota()
    {
        return $this->belongsTo(MascotaModel::class, 'id_mascota');
    }

    public function medico()
    {
        return $this->belongsTo(UsuarioModel::class, 'id_medico');
    }
}
