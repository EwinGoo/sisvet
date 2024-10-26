<?php

namespace App\Http\Controllers\Backend\Tienda;

use App\Http\Controllers\Controller;
use App\Models\PropietarioModel;
use App\Models\Tienda\ClienteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ClienteController extends Controller
{
    public function __construct()
    {
        $this->title = 'Clientes';
        $this->page = 'admin-cliente';
        $this->pageURL = 'tienda/admin-cliente';
        $this->area = 'Tienda';
    }
    public function index(Request $request)
    {
        if (request()->ajax() || $request->get('query')) {
            /* init::Listar propietarios */
            if ($request->get('query')) {
                $data = ClienteModel::getCliente($request->get('query'));
            } else {
                $data = ClienteModel::getCliente();
            }
            return response()->json(['data' => $data], 200);
        }
        return $this->render("tienda.cliente.index");
    }

    public function store(Request $request)
    {
        /* init::Guardar cliente */
        $validator = Validator::make($request->all(), [
            'ci' => 'required|unique:clientes,ci',
            'nombre' => 'required',
            'paterno' => 'required',
            'celular' => 'nullable|numeric|digits:8',
            'direccion' => 'nullable|string',
            // 'email' => 'nullable|email|unique:clientes,email',
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
        $cliente = ClienteModel::create([
            'nombre' => $request->nombre,
            'id_usuario' => Auth::id(),
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'ci' => $request->ci,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
        ]);
        if (!$cliente) {
            $data = [
                'message' => 'Error al registrar',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'cliente' => $cliente,
            'message' => 'Cliente registrado exitosamente',
            'status' => 201
        ];
        return response()->json($data, 201);
    }
    public function update(Request $request, $id)
    {
        $cliente = ClienteModel::find($id);
        if (!$cliente) {
            $data = [
                'message' => 'cliente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'ci' => [
                'required',
                Rule::unique('clientes')->ignore($cliente->id_cliente, 'id_cliente'),
            ],
            'nombre' => 'required',
            'paterno' => 'required',
            'celular' => 'nullable|numeric|digits:8',
            // 'email' => 'nullable|email|unique:clientes,email',
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
        $cliente->update([
            'ci' => $request->ci,
            'nombre' => $request->nombre,
            'id_usuario' => Auth::id(),
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
        ]);
        if (!$cliente) {
            $data = [
                'message' => 'Error al actualizar',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'message' => 'cliente actualizado exitosamente',
            'cliente' => $cliente,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function destroy($id = null)
    {
        $cliente = ClienteModel::find($id);
        if (!$cliente) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $cliente->delete();
        $data = [
            'message' => 'Cliente eliminado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
