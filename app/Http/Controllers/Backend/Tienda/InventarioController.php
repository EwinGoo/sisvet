<?php

namespace App\Http\Controllers\Backend\Tienda;

use App\Http\Controllers\Controller;
use App\Models\PropietarioModel;
use App\Models\Tienda\CompraModel;
use App\Models\Tienda\ProductoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function __construct()
    {
        $this->title = 'Inventario';
        $this->page = 'admin-inventario';
        $this->pageURL = 'tienda/admin-inventario';
        $this->area = 'Tienda';
    }
    public function index()
    {
        if (request()->ajax()) {
            $productos = ProductoModel::select(['id_producto', 'nombre_producto'])
                ->with(['ultimaCompra:id_producto,precio_venta,fecha_caducidad'])
                ->withSum('compras', 'cantidad_compra')
                ->withSum('ventas', 'cantidad')
                ->get()
                ->map(function ($producto) {
                    return [
                        'id_producto' => $producto->id_producto,
                        'nombre_producto' => $producto->nombre_producto,
                        'precio_venta_actual' => $producto->ultimaCompra->precio_venta ?? 0,
                        'fecha_caducidad_actual' => $producto->ultimaCompra->fecha_caducidad ?? null,
                        'cantidad_disponible' => max(0, $producto->compras_sum_cantidad_compra - $producto->ventas_sum_cantidad),
                    ];
                });

            return response()->json(['data' => $productos], 200);
        }
        return $this->render("tienda.inventario.index");
    }

    public function reporte()
    {
        $data = ['nombre' => 'Ejemplo'];
        $pdf = Pdf::loadView('backend.reportes.inventario-reporte', $data);
        $pdf->setPaper('letter', 'portrait');
        // return $pdf->download('reporte.pdf');

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,  // Habilitar PHP dentro de la vista
        ]);

        return $pdf->stream('reporte.pdf');
    }
}
