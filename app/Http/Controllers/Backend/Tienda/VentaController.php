<?php

namespace App\Http\Controllers\Backend\Tienda;

use App\Http\Controllers\Controller;
use App\Models\PropietarioModel;
use App\Models\Tienda\DetalleVentaModel;
use App\Models\Tienda\VentaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $data = VentaModel::select('*')
                ->selectRaw("CONCAT_WS(' ', c.nombre, c.paterno, IFNULL(c.materno, '')) as cliente")
                ->selectRaw("CONCAT_WS(' ', u.nombre, u.paterno, IFNULL(u.materno, '')) as vendedor")
                ->selectRaw("DATE_FORMAT(fecha_venta, '%d de %M del %Y') as fecha")
                ->selectRaw("DATE_FORMAT(fecha_venta, '%h:%i %p') as hora")
                ->orderBy('id_venta', 'desc')
                ->leftJoin('clientes as c', 'c.id_cliente', '=', 'ventas.id_cliente')
                ->leftJoin('usuarios as u', 'u.id_usuario', '=', 'ventas.id_usuario')
                ->get();
            // dd($data);
            // $data = [];
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
            'id_cliente' => 'nullable|exists:clientes,id_cliente',
            'total_venta' => 'required|numeric',
            'productos' => 'required|array',

        ], [
            'productos.required' => 'Debe agregar al menos un producto.',
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $venta = VentaModel::create([
            'id_usuario' => Auth::id(),
            'fecha_venta' => date("Y-m-d H:i:s"),
            'total_venta' => $request->total_venta,
            'id_cliente' => $request->id_cliente,
        ]);

        $detallesVenta = array_map(function ($producto) use ($venta) {
            return [
                'id_venta' => $venta->id_venta,
                'id_producto' => $producto['codigo'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio'],
                'subtotal' => $producto['subtotal'],
            ];
        }, $request->productos);

        // Inserción masiva
        DetalleVentaModel::insert($detallesVenta);

        if (!$venta) {
            $data = [
                'message' => 'Error al registrar',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'venta' => $venta,
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
                'message' => 'Venta realizada exitosamente',
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
        $venta = VentaModel::find($id);
        if (!$venta) {
            $data = [
                'message' => 'Venta no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $venta->delete();
        $data = [
            'message' => 'Venta eliminada exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
