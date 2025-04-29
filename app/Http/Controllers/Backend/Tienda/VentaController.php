<?php

namespace App\Http\Controllers\Backend\Tienda;

use App\Http\Controllers\Controller;
use App\Models\PropietarioModel;
use App\Models\Tienda\CompraModel;
use App\Models\Tienda\DetalleVentaModel;
use App\Models\Tienda\ProductoModel;
use App\Models\Tienda\VentaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        /* Validación de datos */
        $validator = Validator::make($request->all(), [
            'id_cliente' => 'nullable|exists:clientes,id_cliente',
            'total_venta' => 'required|numeric',
            'productos' => 'required|array',
        ], [
            'productos.required' => 'Debe agregar al menos un producto.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Validar stock basado en COMPRAS (no en ProductoModel->cantidad)
        foreach ($request->productos as $producto) {
            $productoModel = ProductoModel::find($producto['codigo']);

            if (!$productoModel) {
                return response()->json([
                    'message' => 'Producto no encontrado (Código: ' . $producto['codigo'] . ')',
                    'status' => 400
                ], 400);
            }

            // 1. Sumar todas las compras del producto
            $totalCompras = CompraModel::where('id_producto', $producto['codigo'])
                ->sum('cantidad_compra');

            // 2. Sumar todas las ventas del producto (para restarlas)
            $totalVentas = DetalleVentaModel::where('id_producto', $producto['codigo'])
                ->sum('cantidad');

            // 3. Stock disponible = Compras - Ventas
            $stockDisponible = $totalCompras - $totalVentas;

            if ($stockDisponible < $producto['cantidad']) {
                return response()->json([
                    'message' => 'Stock insuficiente para el producto: ' . $productoModel->nombre_producto .
                        ' (Stock disponible: ' . $stockDisponible . ', Solicitado: ' . $producto['cantidad'] . ')',
                    'status' => 400
                ], 400);
            }
        }

        // Iniciar transacción para asegurar integridad
        DB::beginTransaction();

        // Validar stock y preparar decremento
        // foreach ($request->productos as $producto) {
        //     $productoModel = ProductoModel::find($producto['codigo']);
        //     if (!$productoModel) {
        //         return response()->json(['message' => 'Producto no encontrado', 'status' => 400], 400);
        //     }

        //     // 1. Obtener compras del producto (ordenadas por fecha ASC para FIFO)
        //     $compras = CompraModel::where('id_producto', $producto['codigo'])
        //         ->orderBy('fecha_compra', 'asc')
        //         ->get();

        //     // 2. Calcular stock disponible
        //     $stockDisponible = $compras->sum('cantidad_compra') - DetalleVentaModel::where('id_producto', $producto['codigo'])->sum('cantidad');

        //     if ($stockDisponible < $producto['cantidad']) {
        //         return response()->json([
        //             'message' => 'Stock insuficiente. Disponible: ' . $stockDisponible,
        //             'status' => 400
        //         ], 400);
        //     }

        //     // 3. Descontar de compras (FIFO)
        //     $cantidadRestante = $producto['cantidad'];
        //     foreach ($compras as $compra) {
        //         if ($cantidadRestante <= 0) break;

        //         $cantidadADescontar = min($compra->cantidad_compra, $cantidadRestante);
        //         $compra->decrement('cantidad_compra', $cantidadADescontar);
        //         $cantidadRestante -= $cantidadADescontar;
        //     }
        // }

        try {
            // Crear la venta (igual que antes)
            $venta = VentaModel::create([
                'id_usuario' => Auth::id(),
                'fecha_venta' => date("Y-m-d H:i:s"),
                'total_venta' => $request->total_venta,
                'id_cliente' => $request->id_cliente,
            ]);

            // Preparar detalles de venta (NO reducir stock en ProductoModel)
            $detallesVenta = [];
            foreach ($request->productos as $producto) {
                $detallesVenta[] = [
                    'id_venta' => $venta->id_venta,
                    'id_producto' => $producto['codigo'],
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $producto['precio'],
                    'subtotal' => $producto['subtotal'],
                ];
            }

            // Insertar detalles de venta
            DetalleVentaModel::insert($detallesVenta);

            DB::commit();

            return response()->json([
                'message' => 'Venta registrada exitosamente (stock validado por compras)',
                'venta' => $venta,
                'status' => 201
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al registrar la venta: ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }
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

    public function detalle($id)
    {
        // Obtener información principal de la venta
        $venta = VentaModel::select('ventas.*')
            ->selectRaw("CONCAT_WS(' ', c.nombre, c.paterno, IFNULL(c.materno, '')) as cliente")
            ->selectRaw("CONCAT_WS(' ', u.nombre, u.paterno, IFNULL(u.materno, '')) as vendedor")
            ->selectRaw("DATE_FORMAT(fecha_venta, '%d de %M del %Y') as fecha")
            ->selectRaw("DATE_FORMAT(fecha_venta, '%h:%i %p') as hora")
            ->leftJoin('clientes as c', 'c.id_cliente', '=', 'ventas.id_cliente')
            ->leftJoin('usuarios as u', 'u.id_usuario', '=', 'ventas.id_usuario')
            ->find($id);

        if (!$venta) {
            return response()->json([
                'message' => 'Venta no encontrada',
                'status' => 404
            ], 404);
        }

        // Obtener detalles de la venta
        $detalles = DetalleVentaModel::select(
            'detalles_venta.*',
            'p.nombre_producto',
            'p.id_producto'
        )
            ->leftJoin('productos as p', 'p.id_producto', '=', 'detalles_venta.id_producto')
            ->where('id_venta', $id)
            ->get();

        return response()->json([
            'venta' => $venta,
            'detalles' => $detalles,
            'status' => 200
        ], 200);
    }
}
