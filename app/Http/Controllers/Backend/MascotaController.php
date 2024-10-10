<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MascotaModel;
use App\Models\PropietarioModel;
use App\Models\AnimalModel;
use App\Models\HistorialClinicoModel;
use App\Models\RazaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class MascotaController extends Controller
{
    public function __construct()
    {
        $this->title = 'Mascotas';
        $this->page = 'admin-mascota';
    }
    public function index()
    {
        /* init::Listar Mascotas */
        $this->data['propietarios'] = PropietarioModel::select('*')->selectRaw("CONCAT_WS(' ', nombre, paterno, IFNULL(materno, '')) as nombre_completo")->orderBy('id_propietario', 'desc')->get();
        $this->data['razas'] =  RazaModel::get();
        $this->data['animales'] =  AnimalModel::get();
        $this->data['historiales'] =  HistorialClinicoModel::get();
        // dd($this->data['historiales']);
        if (request()->ajax()) {
            $data = MascotaModel::getMascota();
            return response()->json(['data' => $data], 200);
        }
        return $this->render("mascota.index");
    }
    public function store(Request $request)
    {
        /* init::Guardar mascota */
        $validator = Validator::make($request->all(), [
            'nombre_mascota' => 'required',
            'id_propietario' => 'required',
            'id_animal' => 'required',
            'years' => 'nullable|numeric|max:99',
            'meses' => 'nullable|numeric|max:12',
        ], [
            'nombre_mascota.required' => 'Campo nombre es requerido',
            'id_propietario.required' => 'Campo propietario es requerido',
            'id_propietario.required' => 'Campo propietario es requerido',
            'id_animal.required' => 'Campo tipo mascota es requerido',
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $mascota = MascotaModel::create([
            'nombre_mascota' => $request->nombre_mascota,
            'id_propietario' => $request->id_propietario,
            'id_raza' => $request->id_raza,
            'vacunas' => $request->vacunas,
            'genero' => $request->genero,
            'color' => $request->color,
            'years' => $request->years,
            'meses' => $request->meses,
            'id_animal' => $request->id_animal,
        ]);
        if (!$mascota) {
            $data = [
                'message' => 'Error al registrar',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'mascota' => $mascota,
            'message' => 'Mascota registrado exitosamente',
            'status' => 201
        ];
        return response()->json($data, 201);
    }
    public function update(Request $request, $id)
    {
        $mascota = MascotaModel::find($id);
        if (!$mascota) {
            $data = [
                'message' => 'mascota no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre_mascota' => 'required',
            'id_propietario' => 'required',
            'id_animal' => 'required',
            'years' => 'nullable|integer|min:0|max:99',
            'meses' => 'nullable|integer|min:0|max:99',
        ], [
            'nombre_mascota.required' => 'Campo nombre es requerido',
            'id_propietario.required' => 'Campo propietario es requerido',
            'id_propietario.required' => 'Campo propietario es requerido',
            'id_animal.required' => 'Campo tipo mascota es requerido',
            'years.max' => 'No pude ser mayor a 99',
            'meses.max' => 'No pude ser mayor a 99',
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $mascota->update([
            'nombre_mascota' => $request->nombre_mascota,
            'id_propietario' => $request->id_propietario,
            'id_raza' => $request->id_raza,
            'vacunas' => $request->vacunas,
            'genero' => $request->genero,
            'color' => $request->color,
            'years' => $request->years,
            'meses' => $request->meses,
            'id_animal' => $request->id_animal,
        ]);
        if (!$mascota) {
            $data = [
                'message' => 'Error al actualizar',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'message' => 'Mascota actualizado correctamente.',
            'mascota' => $mascota,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function destroy($id = null)
    {
        $mascota = MascotaModel::find($id);
        if (!$mascota) {
            $data = [
                'message' => 'mascota no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $mascota->delete();
        $data = [
            'message' => 'Mascota eliminado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function historialClinicoSave(Request $request)
    {
        try {
            $historialClinico = HistorialClinicoModel::create([
                'id_mascota' => $request->id_mascota,
                'id_usuario' => Auth::id(),
            ]);
            $redirectUrl = route('admin.historial.edit', $historialClinico->id);
            return response()->json([
                'message' => 'Historial clínico guardado con éxito',
                'data' => $historialClinico,
                'redirectUrl' => $redirectUrl
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar el historial clínico',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function anamnesisSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_mascota' => 'required|exists:mascotas,id',
            'enfermedades_anteriores' => 'required|string',
            'tratamientos_recientes' => 'required|string',
            'ultima_desparasitacion' => 'required|date',
            'vacunas' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $id = DB::table('anamnesis')->insertGetId([
                'id_mascota' => $request->id_mascota,
                'enfermedades_anteriores' => $request->enfermedades_anteriores,
                'tratamientos_recientes' => $request->tratamientos_recientes,
                'ultima_desparasitacion' => $request->ultima_desparasitacion,
                'vacunas' => $request->vacunas,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $anamnesis = DB::table('anamnesis')->where('id', $id)->first();

            return response()->json([
                'message' => 'Anamnesis guardada con éxito',
                'data' => $anamnesis
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar la anamnesis',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function examenSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_mascota' => 'required|exists:mascotas,id',
            'fecha' => 'required|date',
            'temperatura' => 'required|numeric',
            'frecuencia_cardiaca' => 'required|integer',
            'frecuencia_respiratoria' => 'required|integer',
            'mucosa' => 'required|string',
            'rc' => 'required|string',
            'inspeccion' => 'required|string',
            'palpitacion' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $id = DB::table('examenes')->insertGetId([
                'id_mascota' => $request->id_mascota,
                'fecha' => $request->fecha,
                'temperatura' => $request->temperatura,
                'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
                'frecuencia_respiratoria' => $request->frecuencia_respiratoria,
                'mucosa' => $request->mucosa,
                'rc' => $request->rc,
                'inspeccion' => $request->inspeccion,
                'palpitacion' => $request->palpitacion,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $examen = DB::table('examenes')->where('id', $id)->first();

            return response()->json([
                'message' => 'Examen guardado con éxito',
                'data' => $examen
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar el examen',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function genericSave(Request $request, $table)
    {
        $validator = Validator::make($request->all(), [
            'id_mascota' => 'required|exists:mascotas,id',
            'fecha' => 'required|date',
            'descripcion' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $id = DB::table($table)->insertGetId([
                'id_mascota' => $request->id_mascota,
                'fecha' => $request->fecha,
                'descripcion' => $request->descripcion,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $record = DB::table($table)->where('id', $id)->first();

            return response()->json([
                'message' => ucfirst($table) . ' guardado con éxito',
                'data' => $record
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar ' . $table,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sintomasSave(Request $request)
    {
        return $this->genericSave($request, 'sintomas');
    }

    public function diagnosticoSave(Request $request)
    {
        return $this->genericSave($request, 'diagnosticos');
    }

    public function tratamientoSave(Request $request)
    {
        return $this->genericSave($request, 'tratamientos');
    }

    public function evolucionSave(Request $request)
    {
        return $this->genericSave($request, 'evoluciones');
    }
}
