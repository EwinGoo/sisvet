<?php

namespace App\Http\Controllers\Backend\Tienda;

use App\Http\Controllers\Controller;
use App\Models\PropietarioModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class VentaController extends Controller
{
    public function __construct()
    {
        $this->title = 'Ventas';
        $this->page = 'admin-venta';
        $this->pageURL = 'tienda/admin-venta';
        $this->area = 'Tienda';

    }
    public function index()
    {
        if (request()->ajax()) {
            /* init::Listar propietarios */
            // $data = PropietarioModel::select('*')->selectRaw("CONCAT_WS(' ', nombre, paterno, IFNULL(materno, '')) as nombre_completo")->orderBy('id_propietario', 'desc')->get();
            $data= [];
            return response()->json(['data' => $data], 200);
        }
        return $this->render("tienda.ventas.index");
    }
    public function create()
    {
        $this->title = "Detalle venta";
        $this->pageURL = 'tienda/admin-venta/detalle-venta';
        return $this->render("tienda.ventas.detalle-venta");
    }

    public function store(Request $request)
    {
        /* init::Guardar propietario */
        $validator = Validator::make($request->all(), [
            'ci' => 'required|unique:propietarios,ci',
            'nombre' => 'required',
            'paterno' => 'required',
            'celular' => 'required|numeric|digits:8',
            'direccion' => 'required',
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
        $propietario = PropietarioModel::create([
            'nombre' => $request->nombre,
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'ci' => $request->ci,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
        ]);
        if (!$propietario) {
            $data = [
                'message' => 'Error al registrar',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'propietario' => $propietario,
            'status' => 201
        ];
        return response()->json($data, 201);
    }
    public function update(Request $request, $id)
    {
        $propietario = PropietarioModel::find($id);
        if (!$propietario) {
            $data = [
                'message' => 'propietario no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'ci' => [
                'required',
                Rule::unique('propietarios')->ignore($propietario->id_propietario, 'id_propietario'),
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
        $propietario->update([
            'nombre' => $request->nombre, //eliminar espacios
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'ci' => $request->ci,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
        ]);
        if (!$propietario) {
            $data = [
                'message' => 'Error al actualizar',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'message' => 'Propietario actualizado exitosamente',
            'propietario' => $propietario,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function destroy($id = null)
    {
        $propietario = PropietarioModel::find($id);
        if (!$propietario) {
            $data = [
                'message' => 'Propietario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $propietario->delete();
        $data = [
            'message' => 'Propietario eliminado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
