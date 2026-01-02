<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UsuarioModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helpers;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->title = 'Perfil';
        $this->page = 'admin-perfil';
        $this->area = 'Cuenta';
    }

    public function index()
    {
        // $usuario = Auth::id();
        // dd($usuario);
        $usuario = UsuarioModel::find(Auth::id());
        // return view('usuario.perfil', compact('usuario'));
        $this->data['usuario'] = $usuario;
        return $this->render('usuario.perfil');
    }

    public function update(Request $request)
    {

        $usuario = UsuarioModel::find(Auth::id());

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'paterno' => 'required|string|max:100',
            'materno' => 'nullable|string|max:100',
            'celular' => 'required|numeric|digits:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Actualizar datos básicos
        // $usuario->update([
        //     'nombre' => $request->nombre,
        //     'paterno' => $request->paterno,
        //     'materno' => $request->materno,
        //     'celular' => $request->celular
        // ]);

        // Actualizar imagen si se proporcionó
        if ($request->hasFile('image')) {
            $idImage = Helpers::__fileUpload($request, 'image', 'usuarios', $usuario->id_multimedia);
            $usuario->update(['id_multimedia' => $idImage]);
        }
        // dd($);

        return $this->render('usuario.perfil');
            // ->with('success', 'Perfil actualizado correctamente');
    }

    public function getImagenPerfil()
    {
        $usuario = Auth::user();
        if (!$usuario->ruta_archivo) {
            return response()->json(['default' => asset('assets/img/default-profile.png')]);
        }
        return response()->json(['image' => asset('storage/' . $usuario->ruta_archivo)]);
    }
}
