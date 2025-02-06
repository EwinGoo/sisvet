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
use Illuminate\Http\Response;
use Illuminate\View\View;

class HistorialClinicoController extends Controller
{
    public function __construct()
    {
        $this->title = 'Mascotas';
        $this->page = 'admin-mascota';
        $this->area = 'Consultorio';
    }

    public function historial($id = null, $option = null)
    {
        try {
            if (request()->ajax()) {
                $data = HistorialClinicoModel::getDataHistorial($id, $option);

                if (!$data) {
                    return response()->json([
                        'message' => 'No se encontraron historiales para esta mascota',
                        'data' => []
                    ], 200);
                }

                return response()->json(['data' => $data], 200);
            }

            $historial = HistorialClinicoModel::find($id);
            if (!$historial) {
                return $this->handleNotFound($id);
            }

            $this->pageURL = 'admin-mascota/historial';
            $this->data['info'] = HistorialClinicoModel::getHistorial($id);
            return $this->render('mascota.historial.index');
        } catch (\Exception $e) {
            Log::error('Error en historial: ' . $e->getMessage());
            return $this->handleServerError();
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
    public function getFullDataHistorial($id, $option = null)
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 'Solo se permiten solicitudes AJAX'], 400);
        }

        try {
            $data = HistorialClinicoModel::getFullDataHistorial($id, $option);
            if (!$data) {
                return response()->json(['error' => 'Historial no encontrado'], 404);
            }
            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            Log::error('Error en getFullDataHistorial: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener datos'], 500);
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
            // 'inspeccion' => 'required|string',
            // 'palpacion' => 'required|string',
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

        // dd(DB::table('historial_clinico')->where('id_historial', $id)->first());
        // dd($id,$request->inspeccion,$request->palpacion);
        $affected = DB::table('historial_clinico')
            ->where('id_historial', $id)
            ->update([
                'inspeccion' => $request->inspeccion,
                'palpacion' => $request->palpacion,
            ]);
        // dd($affected);
        if ($affected) {
            $record = DB::table('historial_clinico')->where('id_historial', $id)->first();
            return response()->json([
                'status' => 'success',
                'type' => 'anamnesis',
                'message' => 'Parametros actualizados correctamente',
                'data' => $record,
            ]);
        } else {
            // Maneja el caso donde no se actualizó ningún registro
            return response()->json([
                'status' => 'info',
                'errors' => [],
                'type' => 'anamnesis',
                'message' => 'No se pudo actualizar el registro',
            ], 400);
        }
    }

    public function handleHistorialData(Request $request)
    {
        try {
            $option = $request->option;
            if (!isset(HistorialClinicoModel::TABLE_MAPPING[$option])) {
                return response()->json([
                    'message' => 'Opción no válida',
                ], 400);
            }

            $mapping = HistorialClinicoModel::TABLE_MAPPING[$option];

            // dd($mapping);
            //
            // dd($this->__options($request));

            // Validar los campos requeridos según la opción
            $validationRules = array_merge(
                ['id_historial' => 'required|exists:historial_clinico,id_historial'],
                array_fill_keys($mapping['required_fields'], 'required')
            );

            $validator = Validator::make($request->all(), $validationRules);


            if ($request->image) {
                // si ahi imagen inserta
                if (!($idImage = Helpers::__fileUpload($request, 'image', 'historial'))) {
                    $data = [
                        'message' => 'Error al subir la imagen.',
                        'status' => 500
                    ];
                    return response()->json($data, 500);
                }else{
                    $request->merge(['id_multimedia' => $idImage]);
                }
            }

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }
            // $data = $request->all();
            // unset($data['option']);
            $result = HistorialClinicoModel::handleHistorialData($request->except(['option', 'image']), $option);

            return response()->json([
                'message' => $mapping['title'] . ' guardado con éxito',
                'data' => $result
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error en handleHistorialData: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al procesar la solicitud',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteHistorialData($id, $option, $idReg)
    {
        // dd($option, $idReg,HistorialClinicoModel::TABLE_MAPPING[$option]);

        // dd($id);
        // $reg  = HistorialClinicoModel::where('id_', $id)->first();

        try {
            if (!isset(HistorialClinicoModel::TABLE_MAPPING[$option])) {
                return response()->json([
                    'message' => 'Opción no válida'
                ], 400);
            }

            HistorialClinicoModel::deleteHistorialData($option, $idReg);

            return response()->json([
                'message' => HistorialClinicoModel::TABLE_MAPPING[$option]['title'] . ' eliminado con éxito'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error en deleteHistorialData: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al eliminar el registro',
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
