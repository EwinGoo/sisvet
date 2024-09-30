<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UsuarioModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->title = 'Usuarios';
        $this->page = 'admin-usuario';
    }
    public function index()
    {
        /* init::Listar personas */

        if (request()->ajax()) {
            $data = UsuarioModel::get();
            return response()->json(['data' => $data], 200);
        }
        return $this->render("usuario.index");
    }
    public function store(Request $request)
    {
        // dd($_POST);
        /* init::Guardar usuario */
        $validator = Validator::make(
            $request->all(),
            [
                'usuario' => 'required|unique:usuarios,usuario',
                'rol' => 'required',
                'nombre' => 'required',
                'paterno' => 'required',
                'rol' => 'required',
                'email' => 'required',
                'celular' => 'required|numeric|digits:8',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ],
            [
                // 'usuario.required' => 'Seleccione una persona existente.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'usuario.unique' => 'Usuario ya registrado.',
            ]
        );

        // Manejo de errores de validación
        if ($validator->fails()) {
            // if (!$request->has('id_persona') || !$request->has('persona')) {
            //     $validator->errors()->add('persona', 'Seleccione una persona existente');
            // }
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
        $user = UsuarioModel::create([
            'usuario' => $request->usuario,
            'nombre' => $request->nombre,
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'celular' => $request->celular,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);
        if (!$user) {
            $data = [
                'message' => 'Error al registrar',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'persona' => $user,
            'message' => 'Usuario registrado exitosamente',
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function show(UsuarioModel $usuarioModel)
    {
        $id = 1;
        $user = UsuarioModel::find($id);
        if (!$user) {
            $data = [
                'message' => 'Persona no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'persona' => $user,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function edit(UsuarioModel $persona)
    {
        /* init::Editar persona */
        $this->data['persona'] = $persona;
        return $this->render('persona.edit-form');
    }
    public function update(Request $request, $id)
    {
        $user = UsuarioModel::find($id);
        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        // 

        $validator = Validator::make(
            $request->all(),
            array_merge([
                'usuario' => [
                    'required',
                    Rule::unique('usuarios')->ignore($user->usuario, 'usuario'),
                ],
                'rol' => 'required',
                'nombre' => 'required',
                'paterno' => 'required',
                'email' => 'required',
                'celular' => 'required|numeric|digits:8',
            ], $request->change ? ['password' => ['required', 'confirmed', Rules\Password::defaults()]] : []),
            [
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'usuario.unique' => 'Usuario ya registrado.',
            ]
        );

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $user->update(array_merge([
            'usuario' => $request->usuario,
            'nombre' => $request->nombre,
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'celular' => $request->celular,
            'email' => $request->email,
            'rol' => $request->rol,
        ], $request->change ? ['password' => Hash::make($request->password)] : []));
        if (!$user) {
            $data = [
                'message' => 'Error al actualizar',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'message' => 'Usuario actualizado correctamente.',
            'persona' => $user,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function destroy($id = null)
    {
        /* init::Ajax */
        $usuario = UsuarioModel::find($id);
        if (!$usuario) {
            $data = [
                'message' => 'Usuario no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $usuario->delete();

        $data = [
            'message' => 'Usuario eliminado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function changeStatus(Request $request)
    {
        $usuario = UsuarioModel::find($request->id);
        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status' => 404
            ], 404);
        }
        $nuevoEstado = $usuario->estado == '1' ? '0' : '1'; // Si está activo, lo desactiva; si está inactivo, lo activa
        $usuario->estado = $nuevoEstado;
        $usuario->save();
        return response()->json([
            'message' => $nuevoEstado ? 'Usuario activado exitosamente' : 'Usuario desactivado exitosamente',
            'status' => 200,
            'nuevoEstado' => $nuevoEstado
        ], 200);
    }
}
