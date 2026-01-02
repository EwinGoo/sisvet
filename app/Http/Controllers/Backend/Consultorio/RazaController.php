<?php

namespace App\Http\Controllers\Backend\Consultorio;

use App\Http\Controllers\Controller;
use App\Models\Consultorio\RazaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helpers;
use App\Models\AnimalModel;
use Illuminate\Validation\Rule;

class RazaController extends Controller
{
    public function __construct()
    {
        $this->title = 'Razas';
        $this->page = 'admin-raza';
        $this->area = 'Consultorio';
    }

    public function index()
    {
        if (request()->ajax()) {
            $data = RazaModel::getRazas();
            return response()->json(['data' => $data], 200);
        }

        $this->data['animales'] =  AnimalModel::get();
        return $this->render("consultorio.raza.index");
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'raza' => 'required|unique:razas,raza',
                'id_animal' => 'required|exists:animales,id_animal',
                'descripcion' => 'nullable|max:255'
            ],
            [
                'raza.required' => 'El nombre de la raza es requerido',
                'raza.unique' => 'Esta raza ya está registrada',
                'id_animal.required' => 'Debe seleccionar un animal',
                'id_animal.exists' => 'El animal seleccionado no existe'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $raza = RazaModel::create([
            'raza' => $request->raza,
            'descripcion' => $request->descripcion,
            'id_animal' => $request->id_animal
        ]);

        if (!$raza) {
            $data = [
                'message' => 'Error al registrar la raza',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Raza registrada exitosamente',
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function show($id)
    {
        $raza = RazaModel::getRaza($id);
        if (!$raza) {
            $data = [
                'message' => 'Raza no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'raza' => $raza,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $raza = RazaModel::find($id);
        if (!$raza) {
            $data = [
                'message' => 'Raza no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'raza' => [
                    'required',
                    Rule::unique('razas')->ignore($raza->id_raza, 'id_raza'),
                ],
                'id_animal' => 'required|exists:animales,id_animal',
                'descripcion' => 'nullable|max:255'
            ],
            [
                'raza.required' => 'El nombre de la raza es requerido',
                'raza.unique' => 'Esta raza ya está registrada',
                'id_animal.required' => 'Debe seleccionar un animal',
                'id_animal.exists' => 'El animal seleccionado no existe'
            ]
        );

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $raza->update([
            'raza' => $request->raza,
            'descripcion' => $request->descripcion,
            'id_animal' => $request->id_animal
        ]);

        if (!$raza) {
            $data = [
                'message' => 'Error al actualizar la raza',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Raza actualizada correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $raza = RazaModel::find($id);
        if (!$raza) {
            $data = [
                'message' => 'Raza no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $raza->delete();

        $data = [
            'message' => 'Raza eliminada exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function changeStatus(Request $request)
    {
        $raza = RazaModel::find($request->id);
        if (!$raza) {
            return response()->json([
                'message' => 'Raza no encontrada',
                'status' => 404
            ], 404);
        }
        $nuevoEstado = $raza->estado == '1' ? '0' : '1';
        $raza->estado = $nuevoEstado;
        $raza->save();
        return response()->json([
            'message' => $nuevoEstado ? 'Raza activada exitosamente' : 'Raza desactivada exitosamente',
            'status' => 200,
            'nuevoEstado' => $nuevoEstado
        ], 200);
    }
}
