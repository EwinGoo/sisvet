<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Helpers;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MascotaController extends Controller
{
    public function __construct()
    {
        $this->title = 'Mascotas';
        $this->page = 'admin-mascota';
        $this->area = 'Consultorio';
    }
    public function index()
    {
        /* init::Listar Mascotas */
        $this->data['propietarios'] = PropietarioModel::select('*')
            ->selectRaw("CONCAT_WS(' ', nombre, paterno, IFNULL(materno, '')) as nombre_completo")
            ->orderBy('id_propietario', 'desc')
            ->get();

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
    public function getRazas($id = null)
    {
        if (request()->ajax()) {
            $data = [
                'razas' => RazaModel::where('id_animal', $id)->get(),
                'status' => 200
            ];
            return response()->json($data, 200);
        }
    }
    public function store(Request $request)
    {
        /* init::Guardar mascota */
        $validator = Validator::make($request->all(), [
            'nombre_mascota' => 'required',
            'id_propietario' => 'required',
            'id_animal' => 'required',
            'image' => 'nullable|file|max:5000|mimes:png,jpg,jpeg',
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
        if (!($idImage = Helpers::__fileUpload($request, 'image', 'mascotas')) && $request->hasFile('image')) {
            $data = [
                'message' => 'Error al subir la imagen.',
                'status' => 500
            ];
            return response()->json($data, 500);
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
            'id_multimedia' => $idImage,
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
            'image' => 'nullable|file|max:5000|mimes:png,jpg,jpeg',
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

        if ($request->image) {
            if (!($idImage = Helpers::__fileUpload($request, 'image', 'mascotas', $mascota->id_multimedia))) {
                $data = [
                    'message' => 'Error al subir la imagen.',
                    'status' => 500
                ];
                return response()->json($data, 500);
            }
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
    public function historialIndex($id)
    {
        try {
            $historial = HistorialClinicoModel::find($id);
            if (!$historial) {
                return $this->handleNotFound($id);
            }
            $this->pageURL = 'admin-mascota/historial';
            $this->data['info'] = HistorialClinicoModel::getHistorialMascota($id);
            return $this->render('mascota.historial.index');
        } catch (\Exception $e) {
            Log::error('Error en getAllHistorial: ' . $e->getMessage());
            return $this->handleServerError();
        }
    }
    public function getAllHistorial($id)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 'Solo se permiten solicitudes AJAX'], 400);
        }
        try {
            $data = HistorialClinicoModel::getAllHistorialMascota($id);
            if ($data->isEmpty()) {
                return response()->json(['message' => 'No se encontraron historiales para esta mascota', 'data' => []], 200);
            }
            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            Log::error('Error en getAllHistorial: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al obtener los historiales'], 500);
        }
    }

    public function historialClinicoSave(Request $request)
    {
        $existingHistorial  =   HistorialClinicoModel::where('id_mascota', $request->id_mascota)->first();
        if (!$existingHistorial) {
            try {
                $historialClinico = HistorialClinicoModel::create([
                    'id_mascota' => $request->id_mascota,
                    'id_usuario' => Auth::id(),
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Error al guardar el historial clínico',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
        return redirect()->route('admin-mascota.historial.index', ['id' => $existingHistorial->id_historial ?? $historialClinico->id_historial]);
    }
    public function getFullDataHistorial($id)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 'Solo se permiten solicitudes AJAX'], 400);
        }
        try {
            $data = HistorialClinicoModel::getFullDataHistorial($id);
            if ($data === null) {
                return response()->json(['error' => 'Historial no encontrado'], 404);
            }
            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            Log::error('Error en getFullDataHistorial: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al obtener los historiales'], 500);
        }
    }
    public function anamnesisUpdate(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_historial' => 'required|exists:historial_clinico,id_historial',
                'enfermedades_anteriores' => 'required|string|max:1000',
                'tratamientos_recientes' => 'required|string|max:1000',
                'vacunas' => 'required|string|max:500',
                'ultima_desparasitacion' => 'required|date',
            ]);

            DB::beginTransaction();

            // Verificar si la anamnesis existe
            $anamnesis = DB::table('historial_clinico')->where('id_historial', $validatedData['id_historial'])->first();
            if (!$anamnesis) {
                throw new \Exception("Anamnesis no encontrada");
            }

            // Actualizar la anamnesis
            $updated = DB::table('historial_clinico')
                ->where('id_historial', $validatedData['id_historial'])
                ->update([
                    'enfermedades_anteriores' => $validatedData['enfermedades_anteriores'],
                    'tratamientos_recientes' => $validatedData['tratamientos_recientes'],
                    'ultima_desparasitacion' => $validatedData['ultima_desparasitacion'],
                    'vacunas' => $validatedData['vacunas'],
                    'updated_at' => now(),
                ]);

            if (!$updated) {
                throw new \Exception("No se pudo actualizar la anamnesis");
            }

            DB::commit();
            // Obtener la anamnesis actualizada
            $updatedAnamnesis = DB::table('historial_clinico')->where('id_historial', $validatedData['id_historial'])->first();

            return response()->json([
                'message' => 'Anamnesis actualizada con éxito',
                'data' => $updatedAnamnesis
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar anamnesis: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al actualizar la anamnesis',
                'error' => 'Ocurrió un error interno. Por favor, inténtelo de nuevo más tarde.'
            ], 500);
        }
    }

    public function examenSave(Request $request)
    {
        if ($request->isUpdateTwoFields) {
            return $this->updateTwoFields($request);
        }
        $validator = Validator::make($request->all(), [
            'id_historial' => 'required|exists:historial_clinico,id_historial',
            'fecha' => 'required|date',
            'temperatura' => 'required|numeric',
            'frecuencia_cardiaca' => 'required|integer',
            'frecuencia_respiratoria' => 'required|integer',
            'mucosa' => 'required|string',
            'rc' => 'required|string',
            'inspeccion' => 'required|string',
            'palpacion' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            $id = DB::table('examen_general')->insertGetId([
                'id_historial' => $request->id_historial,
                'fecha' => $request->fecha,
                'temperatura' => $request->temperatura,
                'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
                'frecuencia_respiratoria' => $request->frecuencia_respiratoria,
                'mucosa' => $request->mucosa,
                'rc' => $request->rc,
                'inspeccion' => $request->inspeccion,
                'palpacion' => $request->palpacion,
            ]);

            $examen = DB::table('examen_general')->where('id_examen', $id)->first();

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
    public function updateTwoFields(Request $request)
    {
        $id = $request->id_historial;
        $affected = DB::table('historial_clinico')
            ->where('id_historial', $id)
            ->update([
                'inspeccion' => $request->inspeccion,
                'palpacion' => $request->palpacion,
            ]);
        if ($affected) {
            $record = DB::table('historial_clinico')->where('id_historial', $id)->first();
            return response()->json([
                'status' => 'success',
                'message' => 'Parametros actualizados correctamente',
                'data' => $record,
            ]);
        } else {
            // Maneja el caso donde no se actualizó ningún registro
            return response()->json([
                'status' => 'error',
                'message' => 'No se pudo actualizar el registro',
            ], 400);
        }
    }

    public function handleHistorialData(Request $request)
    {
        $specificRules = [
            'metodos_complementarios' => [
                'examen' => 'nullable|required_without_all:resultados|string|max:500',
                'resultados' => 'nullable|required_without_all:examen|string|max:500',
            ],
            'evolucion' => [
                'fecha_hora' => 'required|date_format:Y-m-d\TH:i',
                'descripcion' => 'required|string|max:500',
            ],
            'default' => [
                'fecha' => 'required|date_format:Y-m-d',
                'descripcion' => 'required|string|max:500',
            ],

        ];
        $optionRules = $specificRules[$request->option] ?? $specificRules['default'];

        $validator = Validator::make(
            $request->all(),
            array_merge([
                'id_historial' => 'required|exists:historial_clinico,id_historial',
            ], $optionRules)
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            [$table, $idTable, $fields, $title] = $this->__options($request);
            $id = DB::table($table)->insertGetId(array_merge(
                $fields,
                $request->fecha_hora ? ['fecha_hora' => $request->fecha_hora] : ['fecha' => $request->fecha]
            ));
            $record = DB::table($table)->where($idTable, $id)->first();

            return response()->json([
                'message' => $title . ' guardado con éxito',
                'data' => $record
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar ' . $title,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function __options($request)
    {
        $id = null;
        $title = "";
        $fields = [
            'id_historial' => $request->id_historial,
            'descripcion' => $request->descripcion,
        ];
        // dd($option);
        switch ($request->option) {
            case 'sintomas':
                $id = 'id_sintoma';
                $title = "Sintomas";
                break;
            case 'metodos_complementarios':
                $id = 'id_metodo';
                $title = "Metodo complementario";
                $fields = [
                    'id_historial' => $request->id_historial,
                    'examen' => $request->examen,
                    'resultados' => $request->resultados,
                ];
                break;
            case 'diagnosticos_presuntivos':
                $id = 'id_diagnostico_presuntivo';
                $title = "Diagnostico presuntivo";
                break;
            case 'diagnosticos_definitivos':
                $id = 'id_diagnostico_definitivo';
                $title = "Diagnostico definitivo";
                break;
            case 'tratamiento':
                $id = 'id_tratamiento';
                $title = "Tratamiento";
                break;
            case 'evolucion':
                $id = 'id_evolucion';
                $title = "Evolución";
                break;
        }
        return [$request->option, $id, $fields, $title];
    }

    // public function sintomasSave(Request $request)
    // {
    //     return $this->genericSave($request, 'sintomas');
    // }

    // public function diagnosticoSave(Request $request)
    // {
    //     return $this->genericSave($request, 'diagnosticos');
    // }

    // public function tratamientoSave(Request $request)
    // {
    //     return $this->genericSave($request, 'tratamientos');
    // }

    // public function evolucionSave(Request $request)
    // {
    //     return $this->genericSave($request, 'evoluciones');
    // }

    private function handleNotFound($id)
    {
        Log::warning("Intento de acceder a historial de mascota inexistente. ID: {$id}");
        return redirect()->to('404');
    }

    private function handleServerError()
    {
        if (request()->ajax()) {
            return response()->json(['error' => 'Ocurrió un error al obtener los historiales'], 500);
        }
        return abort(500);
    }
}
