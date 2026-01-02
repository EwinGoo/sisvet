<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UsuarioModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Helpers\Helpers;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->title = 'Usuarios';
        $this->page = 'admin-usuario';
        $this->area = 'Administración';
    }
    public function index()
    {
        /* init::Listar personas */

        if (request()->ajax()) {
            $data = UsuarioModel::getUsers();
            return response()->json(['data' => $data], 200);
        }
        return $this->render("usuario.index");
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'usuario' => 'required|unique:usuarios,usuario',
                'id_rol' => 'required',
                'nombre' => 'required',
                'paterno' => 'required',
                'image' => 'required|file|max:10000|mimes:png,jpg,jpeg',
                'email' => 'required|email|unique:usuarios,email',
                'celular' => 'required|numeric|digits:8',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ],
            [
                // 'usuario.required' => 'Seleccione una persona existente.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'usuario.unique' => 'Usuario ya registrado.',
                'email.unique' => 'Email ya registrado.',
            ]
        );

        // Manejo de errores de validación
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
        if (!($idImage = Helpers::__fileUpload($request, 'image', 'usuarios'))) {
            $data = [
                'message' => 'Error al subir la imagen.',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $user = UsuarioModel::create([
            'usuario' => $request->usuario,
            'nombre' => $request->nombre,
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'celular' => $request->celular,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_multimedia' => $idImage,
            'id_rol' => $request->id_rol,
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
        $idImage = $user->id_multimedia;
        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            array_merge([
                'usuario' => [
                    'required',
                    Rule::unique('usuarios')->ignore($user->usuario, 'usuario'),
                ],
                'id_rol' => 'required',
                'nombre' => 'required',
                'paterno' => 'required',
                'image' => 'nullable|file|max:10000|mimes:png,jpg,jpeg',
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
        if ($request->image) {
            if (!($idImage = Helpers::__fileUpload($request, 'image', 'usuarios', $user->id_multimedia))) {
                $data = [
                    'message' => 'Error al subir la imagen.',
                    'status' => 500
                ];
                return response()->json($data, 500);
            }
        }
        $user->update(array_merge([
            'usuario' => $request->usuario,
            'nombre' => $request->nombre,
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'celular' => $request->celular,
            'email' => $request->email,
            'id_multimedia' => $idImage,
            'id_rol' => $request->id_rol,
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
    public function getImage($id)
    {
        $user = UsuarioModel::getUser($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        if (!$user->ruta_archivo) {
            return response()->json(['message' => 'Ruta de imagen no disponible'], 404);
        }
        $base64Image = Helpers::getImage($user->ruta_archivo);
        return response()->json(['image' => $base64Image]);
    }
}
