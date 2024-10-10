<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropietarioModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'propietarios';
    protected $primaryKey = 'id_propietario';
    protected $fillable = ['ci', 'nombre', 'paterno', 'materno', 'celular', 'direccion'];
    protected $guarded = [];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public function getEstudiante($ci)
    {
        return DB::table('estudiantes as e')
            ->leftJoin('personas as p', 'e.id_persona', '=', 'p.id_persona')
            ->select(
                'e.*',
                'p.*',
                'p.nombre as nombres',
                DB::raw("CONCAT(p.paterno, ' ', p.materno) as apellidos")
            )
            ->where('p.ci', $ci)  // Asegúrate de que la columna 'ci' se refiera a la tabla correcta.
            ->first();
    }
    public static function getPersona($string)
    {
        $results = self::where(function ($query) use ($string) {
            $query->whereRaw('LOWER(ci) = LOWER(?)', [$string])
                ->orWhereRaw('LOWER(nombre) = LOWER(?)', [$string])
                ->orWhereRaw('LOWER(paterno) = LOWER(?)', [$string])
                ->orWhereRaw('LOWER(materno) = LOWER(?)', [$string])
                ->orWhereRaw('LOWER(ci) LIKE LOWER(?)', ['%' . $string . '%'])
                ->orWhereRaw('LOWER(nombre) LIKE LOWER(?)', ['%' . $string . '%'])
                ->orWhereRaw('LOWER(paterno) LIKE LOWER(?)', ['%' . $string . '%'])
                ->orWhereRaw('LOWER(materno) LIKE LOWER(?)', ['%' . $string . '%']);
        })
            ->where('estado', '1')
            ->orderByRaw("
            CASE
                WHEN LOWER(ci) = LOWER(?) THEN 1
                WHEN LOWER(nombre) = LOWER(?) THEN 2
                WHEN LOWER(paterno) = LOWER(?) THEN 3
                WHEN LOWER(materno) = LOWER(?) THEN 4
                ELSE 5
            END
        ", [$string, $string, $string, $string])
            ->limit(10) // Limitar el número de resultados a 10
            ->get();

        return $results;
    }

    // $results = self::whereRaw('LOWER(ci) LIKE LOWER(?)', [$string . '%'])
    //         ->orWhereRaw('LOWER(nombre) LIKE LOWER(?)', [$string . '%'])
    //         ->orWhereRaw('LOWER(paterno) LIKE LOWER(?)', [$string . '%'])
    //         ->orWhereRaw('LOWER(materno) LIKE LOWER(?)', [$string . '%'])
    //         ->where("estado", '1')
    //         ->limit(10) // Limitar el número de resultados a 10
    //         ->get();

    //     return $results;
}
