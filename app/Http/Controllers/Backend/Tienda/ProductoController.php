<?php

namespace App\Http\Controllers\Backend\Tienda;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\PropietarioModel;
use App\Models\Tienda\CategoriaModel;
use App\Models\Tienda\CompraModel;
use App\Models\Tienda\DetalleVentaModel;
use App\Models\Tienda\ProductoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ProductoController extends Controller
{
    public function __construct()
    {
        $this->title = 'Productos';
        $this->page = 'admin-producto';
        $this->pageURL = 'tienda/admin-producto';
        $this->area = 'Tienda';
    }
    public function index(Request $request)
    {
        $this->data['categorias'] = CategoriaModel::get();
        if (request()->ajax()) {

            /* init::Listar productos */
            if ($request->get('query'))  $data = ProductoModel::getProducto($request->get('query'));
            else $data = ProductoModel::getProducto();

            return response()->json(['data' => $data], 200);
        }
        return $this->render("tienda.producto.index");
    }

    public function store(Request $request)
    {
        /* init::Guardar propietario */
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|max:5000|mimes:png,jpg,jpeg',
            'nombre_producto' => 'required|string|max:90',
            'id_categoria'    => 'required|integer|exists:categorias,id_categoria',
            'descripcion'     => 'nullable|string|max:200',
            // 'precio'          => 'required|numeric|min:0',
            // 'fecha_vencimiento' => 'required',
            // 'fecha_vencimiento' => 'required|date|after:today',
        ], [
            'nombre_producto.required' => 'El producto es requerido',
            'id_categoria.required' => 'El campo categoria es requerido.',
            // 'fecha_vencimiento.after' => 'El campo fecha vencimiento debe ser una fecha posterior a hoy.',
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        if (!($idImage = Helpers::__fileUpload($request, 'image', 'productos')) && $request->hasFile('image')) {
            $data = [
                'message' => 'Error al subir la imagen.',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $producto = ProductoModel::create([
            'nombre_producto' => $request->nombre_producto,
            'id_categoria' => $request->id_categoria,
            'id_usuario' => Auth::id(),
            'descripcion' => $request->descripcion,
            // 'precio' => $request->precio,
            // 'fecha_vencimiento' => $request->fecha_vencimiento,
            'id_multimedia' => $idImage,
        ]);
        if (!$producto) {
            $data = [
                'message' => 'Error al registrar',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'producto' => $producto,
            'message' => 'Producto guardado exitosamente',
            'status' => 201
        ];
        return response()->json($data, 201);
    }
    public function update(Request $request, $id)
    {
        $producto = ProductoModel::find($id);
        if (!$producto) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|file|max:5000|mimes:png,jpg,jpeg',
            'nombre_producto' => 'required|string|max:90',
            'id_categoria'    => 'required|integer|exists:categorias,id_categoria',
            'descripcion'     => 'nullable|string|max:200',
            // 'precio'          => 'required|numeric|min:0',
            // 'fecha_vencimiento' => 'required',
            // 'fecha_vencimiento' => 'required|date|after:today',
        ], [
            'nombre_producto.required' => 'El producto es requerido',
            'id_categoria.required' => 'El campo categoria es requerido.',
            // 'fecha_vencimiento.after' => 'El campo fecha vencimiento debe ser una fecha posterior a hoy.',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        if ($request->image) {
            if (!($idImage = Helpers::__fileUpload($request, 'image', 'productos', $producto->id_multimedia))) {
                $data = [
                    'message' => 'Error al subir la imagen.',
                    'status' => 500
                ];
                return response()->json($data, 500);
            }
        }
        $producto->update([
            'nombre_producto' => $request->nombre_producto,
            'id_categoria' => $request->id_categoria,
            'id_usuario' => Auth::id(),
            'descripcion' => $request->descripcion,
            // 'precio' => $request->precio,
            // 'fecha_vencimiento' => $request->fecha_vencimiento,
            'id_multimedia' => $idImage ?? $producto->id_multimedia
        ]);
        if (!$producto) {
            $data = [
                'message' => 'Error al actualizar',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'message' => 'Producto actualizado exitosamente',
            'producto' => $producto,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function destroy($id = null)
    {
        $producto = ProductoModel::find($id);
        if (!$producto) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $producto->delete();
        $data = [
            'message' => 'Producto eliminado exitosamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function checkStock($id)
    {
        $producto = ProductoModel::find($id);

        if (!$producto) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'status' => 404
            ], 404);
        }
        // dd($id);

        $totalCompras = CompraModel::where('id_producto', $id)->sum('cantidad_compra'); // Suma todas las compras del producto
        $totalVentas = DetalleVentaModel::where('id_producto', $id)->sum('cantidad'); // Suma todas las compras del producto

        // 3. Calcular stock disponible (cantidad actual + compras)

        return response()->json([
            'stock' => $totalCompras - $totalVentas, // Asumiendo que tienes un campo 'cantidad' en tu modelo
            'status' => 200
        ]);
    }


}
