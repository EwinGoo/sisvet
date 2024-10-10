<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait CommonQueries
{
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
            ->where('p.ci', $ci)
            ->first();
    }

    public static function getPersona($string)
    {
        return self::where(function ($query) use ($string) {
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
            ->limit(10)
            ->get();
    }
}
