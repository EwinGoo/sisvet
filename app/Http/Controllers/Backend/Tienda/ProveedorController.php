<?php

namespace App\Http\Controllers\Backend\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Tienda\ProveedorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->title = 'Proveedores';
        $this->page = 'admin-proveedor';
        $this->pageURL = 'tienda/admin-proveedor';
        $this->area = 'Tienda';
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('query')) {
                $data = ProveedorModel::getProveedores($request->get('query'));
            } else {
                $data = ProveedorModel::getProveedores();
            }
            return response()->json(['data' => $data], 200);
        }
        return $this->render("tienda.proveedor.index");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'contacto' => 'nullable|string|max:100',
            'celular' => 'nullable|integer|digits_between:7,8',
            'correo' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
        ], [
            'nombre.required' => 'El titulo del proveedor es requerido',
            'celular.digits_between' => 'El celular debe tener entre 7 y 8 dígitos',
            'correo.email' => 'El correo debe ser una dirección de email válida',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $proveedor = ProveedorModel::create([
            'nombre' => $request->nombre,
            'contacto' => $request->contacto,
            'celular' => $request->celular,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'id_usuario' => Auth::id(),
        ]);

        if (!$proveedor) {
            return response()->json([
                'message' => 'Error al registrar el proveedor',
                'status' => 500
            ], 500);
        }

        return response()->json([
            'proveedor' => $proveedor,
            'message' => 'Proveedor registrado exitosamente',
            'status' => 201
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $proveedor = ProveedorModel::find($id);

        if (!$proveedor) {
            return response()->json([
                'message' => 'Proveedor no encontrado',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'contacto' => 'nullable|string|max:100',
            'celular' => 'nullable|integer|digits_between:7,8',
            'correo' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
        ], [
            'nombre.required' => 'El titulo del proveedor es requerido',
            'celular.digits_between' => 'El celular debe tener entre 7 y 8 dígitos',
            'correo.email' => 'El correo debe ser una dirección de email válida',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $proveedor->update([
            'nombre' => $request->nombre,
            'contacto' => $request->contacto,
            'celular' => $request->celular,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'id_usuario' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Proveedor actualizado exitosamente',
            'proveedor' => $proveedor,
            'status' => 200
        ], 200);
    }

    public function destroy($id)
    {
        $proveedor = ProveedorModel::find($id);

        if (!$proveedor) {
            return response()->json([
                'message' => 'Proveedor no encontrado',
                'status' => 404
            ], 404);
        }

        $proveedor->delete();

        return response()->json([
            'message' => 'Proveedor eliminado exitosamente',
            'status' => 200
        ], 200);
    }
}
