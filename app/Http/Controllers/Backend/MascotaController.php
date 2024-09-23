<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MascotaModel;
use App\Models\PropietarioModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


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
        $data = MascotaModel::getMascota();
        $this->data['propietarios'] = PropietarioModel::select('*')->selectRaw("CONCAT_WS(' ', nombre, paterno, IFNULL(materno, '')) as nombre_completo")->orderBy('id_propietario', 'desc')->get();
        if (request()->ajax()) {
            return response()->json(['data' => $data], 200);
        }
        return $this->render("mascota.index");
    }
    public function listarmascotaAjax()
    {
        $Mascotas = mascotaModel::where('estado', '1')->get();
        // return response()->json($mascota);s

        $mascota = mascotaModel::where('estado', '1')->get();
        if ($mascota->isEmpty()) {
            $data = [
                'message' => 'No se encontraron registros.',
                'status' => 200
            ];
            return response()->json($data, 404);
        }
        $data = [
            'Mascotas' => $Mascotas,
            'status' => 200
        ];
        // return response()->json($mascota, 200);
        return response()->json($data, 200);
    }
    public function create()
    {
        /* init::Crear mascota */
        return $this->render("mascota.form");
    }

    public function store(Request $request)
    {
        /* init::Guardar mascota */
        $validator = Validator::make($request->all(), [
            'nombre_mascota' => 'required',
        ], [
            'nombre_mascota.required' => 'Campo nombre es requerido',
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
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function show(mascotaModel $mascotaModel)
    {
        $id = 1;
        $mascota = mascotaModel::find($id);
        if (!$mascota) {
            $data = [
                'message' => 'mascota no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'mascota' => $mascota,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function edit(mascotaModel $mascota)
    {
        /* init::Editar mascota */
        $this->data['mascota'] = $mascota;
        return $this->render('mascota.edit-form');
    }
    public function update(Request $request, $id)
    {
        $mascota = mascotaModel::find($id);
        if (!$mascota) {
            $data = [
                'message' => 'mascota no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'ci' => [
                'required',
                Rule::unique('Mascotas')->ignore($mascota->id_mascota, 'id_mascota'),
            ],
            'nombre' => 'required',
            'paterno' => 'required',
            'celular' => 'nullable|numeric|digits:8',
        ], [
            'ci.required' => 'Campo cedula es requerido',
            'ci.unique' => 'La cedula ya ha sido tomado.',
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
            'nombre' => $request->nombre, //eliminar espacios
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'ci' => $request->ci,
            'celular' => $request->celular,
        ]);
        if (!$mascota) {
            $data = [
                'message' => 'Error al actualizar',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'message' => 'mascota actualizada executad',
            'mascota' => $mascota,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function destroy($id = null)
    {
        $mascota = mascotaModel::find($id);
        if (!$mascota) {
            $data = [
                'message' => 'mascota no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
    
        $mascota->delete(); // Este método ahora realiza una eliminación lógica
    
        $data = [
            'message' => 'mascota eliminado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
