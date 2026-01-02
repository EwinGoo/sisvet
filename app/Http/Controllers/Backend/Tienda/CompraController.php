<?php

namespace App\Http\Controllers\Backend\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Tienda\CompraModel;
use App\Models\Tienda\ProductoModel;
use App\Models\Tienda\ProveedorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompraController extends Controller
{
    public function __construct()
    {
        $this->title = 'Gestión de Compras';
        $this->page = 'tienda/admin-compra';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['data' => CompraModel::getCompras()]);
        }

        $this->data['proveedores'] = ProveedorModel::all();
        $this->data['productos'] = ProductoModel::all();
        // return view("backend.compras.index", $this->data);
        return $this->render("tienda.compra.index");
    }

    public function show($id)
    {
        $compra = CompraModel::with(['producto', 'usuario'])
            ->findOrFail($id);

        if (request()->ajax()) {
            return response()->json($compra);
        }
    }

    public function getCompra($id)
    {
        return response()->json(CompraModel::findOrFail($id));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_producto' => 'required|exists:productos,id_producto',
            'fecha_compra' => 'required|date',
            'fecha_caducidad' => 'nullable|date',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'cantidad_compra' => 'required|integer|min:1',
        ], [
            'id_producto.required' => 'El campo producto es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $data = $request->all();
        $data['id_usuario'] = Auth::id();
        $data['precio_total_compra'] = $data['precio_compra'] * $data['cantidad_compra'];

        $compra = CompraModel::create($data);

        // Actualizar stock del producto (opcional)
        // ProductoModel::where('id_producto', $request->id_producto)
        //     ->increment('stock', $request->cantidad_compra);

        return response()->json([
            'message' => 'Compra registrada exitosamente',
            'compra' => $compra,
            'status' => 201
        ]);
    }

    public function update(Request $request, $id)
    {
        $compra = CompraModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'id_producto' => 'required|exists:productos,id_producto',
            'fecha_compra' => 'required|date',
            'fecha_caducidad' => 'nullable|date',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'cantidad_compra' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data = $request->all();
        $data['id_usuario'] = Auth::id();
        $data['precio_total_compra'] = $data['precio_compra'] * $data['cantidad_compra'];

        $compra->update($data);
        return response()->json(['message' => 'Compra actualizada']);
    }

    public function destroy($id)
    {
        $compra = CompraModel::findOrFail($id);
        $compra->delete();
        return response()->json(['message' => 'Compra eliminada']);
    }

    public function getProductos()
    {
        $productos = ProductoModel::with(['categoria'])->select('id_producto', 'nombre_producto', 'precio_compra', 'precio_venta')
            ->get();

        return response()->json([
            'productos' => $productos
        ]);
    }
}
