<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MascotaModel;
use App\Models\PropietarioModel;
use App\Models\AnimalModel;
use App\Models\RazaModel;
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
        $this->data['propietarios'] = PropietarioModel::select('*')->selectRaw("CONCAT_WS(' ', nombre, paterno, IFNULL(materno, '')) as nombre_completo")->orderBy('id_propietario', 'desc')->get();
        $this->data['razas'] =  RazaModel::get();
        $this->data['animales'] =  AnimalModel::get();
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
            'edad' => $request->edad,
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
        $mascota->update([
            'nombre_mascota' => $request->nombre_mascota,
            'id_propietario' => $request->id_propietario,
            'id_raza' => $request->id_raza,
            'vacunas' => $request->vacunas,
            'genero' => $request->genero,
            'color' => $request->color,
            'edad' => $request->edad,
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
}
