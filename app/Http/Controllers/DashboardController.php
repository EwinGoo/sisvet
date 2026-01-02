<?php

namespace App\Http\Controllers;

use App\Models\Consultorio\CitaModel;
use Carbon\Carbon;
use App\Models\MascotaModel;
use App\Models\Tienda\ProductoModel;
use App\Models\Tienda\VentaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $this->data['total_mascotas'] = MascotaModel::count();
        $this->data['porcentaje_crecimiento'] = $this->getPorcentajeCrecimiento();
        $this->data['total_vendido'] = VentaModel::whereDate('fecha_venta', Carbon::today())->sum('total_venta');
        $citas = CitaModel::selectRaw('COUNT(*) as total_citas_hoy,
                              SUM(CASE WHEN estado = "pendiente" THEN 1 ELSE 0 END) as citas_pendientes')
            ->whereDate('fecha_hora', Carbon::today())
            ->where('id_medico', auth()->id())
            ->first();

        $this->data['citas_hoy'] = $citas->total_citas_hoy;
        $this->data['citas_pendientes'] = $citas->citas_pendientes;
        $this->data['porcentaje_vendido'] = $this->getPorcentajeVendido();
        $this->data['mascotas_registradas_hoy'] = MascotaModel::whereDate('created_at', Carbon::today())->count();

        $ventasPorMes = VentaModel::selectRaw('DATE_FORMAT(fecha_venta, "%b") as mes, SUM(total_venta) as total')
            ->whereBetween('fecha_venta', [Carbon::now()->subMonths(9), Carbon::now()])
            ->groupBy('mes')
            ->orderByRaw('MIN(fecha_venta)')
            ->pluck('total', 'mes');

        // dd($ventasPorMes);

        $this->data['labels'] = $ventasPorMes->keys();  // Meses
        $this->data['data'] = $ventasPorMes->values();  // Totales de ventas
        // dd($this->data['labels'],$this->data['data']);

        $inicioSemana = Carbon::now()->startOfWeek(); // Lunes
        $finSemana = Carbon::now()->endOfWeek();     // Domingo

        // Obtener ventas agrupadas por día de la semana actual
        $ventasPorDia = VentaModel::select(
            DB::raw('DAYOFWEEK(fecha_venta) as dia_semana'),
            DB::raw('COUNT(id_venta) as cantidad') // Cambiado de SUM(total_venta) a COUNT(id)
        )
            ->whereBetween('fecha_venta', [$inicioSemana, $finSemana])
            ->groupBy('dia_semana')
            ->orderBy('dia_semana')
            ->get()
            ->keyBy('dia_semana');

        // Preparar array con 7 días (inicializados en 0 si no hay datos)
        $datosGrafico = [];
        for ($i = 1; $i <= 7; $i++) {
            $datosGrafico[] = $ventasPorDia->has($i) ? $ventasPorDia[$i]->cantidad : 0;
        }

        $this->data['ventas_semana'] = $datosGrafico;

        // Vacunas

        $vacunasPorTipo = DB::table('vacunas')
            ->join('tipos_vacunas', 'vacunas.id_tipo_vacuna', '=', 'tipos_vacunas.id_tipo_vacuna')
            ->select(
                'tipos_vacunas.nombre_vacuna as nombre',
                DB::raw('COUNT(vacunas.id_vacuna) as cantidad')
            )
            ->groupBy('tipos_vacunas.nombre_vacuna')
            ->orderBy('cantidad', 'DESC')
            ->get();

        // Preparar datos para el gráfico
        $labels = [];
        $data = [];

        foreach ($vacunasPorTipo as $vacuna) {
            $labels[] = $vacuna->nombre;
            $data[] = $vacuna->cantidad;
        }

        $this->data['vacunas'] = [
            'labels' => $labels,
            'data' => $data
        ];

        // Citas por tipo de consulta
        $citasPorTipo = DB::table('citas')
            ->select(
                'tipo_consulta',
                DB::raw('COUNT(*) as cantidad')
            )
            ->groupBy('tipo_consulta')
            ->get();

        // Calcular total de citas
        $totalCitas = $citasPorTipo->sum('cantidad');

        // Preparar datos con porcentajes
        $tiposConsulta = [
            'Consulta general',
            'Vacunación',
            'Urgencia',
            'Cirugía',
            'Estética',
            'Otro'
        ];

        $datos = [];
        $datosGrafico = [];
        $colores = ['#17c1e8', '#cb0c9f', '#3A416F', '#82d616', '#ff9f43', '#ea0606'];

        foreach ($tiposConsulta as $index => $tipo) {
            $citas = $citasPorTipo->firstWhere('tipo_consulta', $tipo);
            $cantidad = $citas ? $citas->cantidad : 0;
            $porcentaje = $totalCitas > 0 ? round(($cantidad / $totalCitas) * 100, 1) : 0;

            $datos[] = [
                'tipo' => $tipo,
                'cantidad' => $cantidad,
                'porcentaje' => $porcentaje,
                'color' => $colores[$index] ?? '#cccccc'
            ];
            $datosGrafico[] = $cantidad;
        }

        // dd($datos,$datosGrafico);

        $this->data['citas_data'] = $datos;
        $this->data['citas_por_tipo']['data'] = $datosGrafico;
        $this->data['citas_por_tipo']['labels'] = $tiposConsulta;
        $this->data['citas_por_tipo']['colores'] = $colores;
        $this->data['total_citas'] = $totalCitas;

        // Invetario de stock de producto por categoria
        $this->data['inventario'] = $this->stockPorCategoria();

        $this->title = 'Panel Principal';
        $this->page = 'dashboard';
        $this->pageURL = 'dashboard';
        $this->area = 'Dashboard';
        return $this->render('dashboard');
    }
    public function getPorcentajeCrecimiento()
    {
        $mesActual = MascotaModel::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $mesAnterior = MascotaModel::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        if ($mesAnterior > 0) {
            $crecimiento = (($mesActual - $mesAnterior) / $mesAnterior) * 100;
        } else {
            $crecimiento = $mesActual > 0 ? 100 : 0; // Si el mes anterior era 0 y este mes hay mascotas, es 100%
        }

        $crecimiento = $crecimiento > 0 ? '+' . round($crecimiento) : round($crecimiento);
        // $crecimiento = $crecimiento > 0 ? '+' . round($crecimiento) : 0;

        return $crecimiento;
    }
    public function getPorcentajeVendido()
    {
        $ventasHoy = VentaModel::whereDate('fecha_venta', Carbon::today())->sum('total_venta');

        // Total de ventas ayer
        $ventasAyer = VentaModel::whereDate('fecha_venta', Carbon::yesterday())->sum('total_venta');

        // Calcular el porcentaje de cambio
        if ($ventasAyer > 0) {
            $cambioPorcentaje = (($ventasHoy - $ventasAyer) / $ventasAyer) * 100;
        } else {
            $cambioPorcentaje = $ventasHoy > 0 ? 100 : 0; // Si ayer fue 0 y hoy hay ventas, el aumento es 100%
        }
        // Redondear al entero más cercano
        $cambioPorcentaje = $cambioPorcentaje > 0 ? '+' . round($cambioPorcentaje) : round($cambioPorcentaje);

        return $cambioPorcentaje;
    }

    public function stockPorCategoria()
    {
        $stockPorCategoria = ProductoModel::select([
            'categorias.nombre_categoria',
            DB::raw('SUM(
                (SELECT COALESCE(SUM(compras.cantidad_compra), 0)
                 FROM compras
                 WHERE compras.id_producto = productos.id_producto) -
                (SELECT COALESCE(SUM(detalles_venta.cantidad), 0)
                 FROM detalles_venta
                 WHERE detalles_venta.id_producto = productos.id_producto)
            ) as stock_total')
        ])
            ->join('categorias', 'categorias.id_categoria', '=', 'productos.id_categoria')
            ->groupBy('categorias.nombre_categoria')
            ->orderBy('stock_total', 'DESC')
            ->get();

        return [
            'labels' => $stockPorCategoria->pluck('nombre_categoria'),
            'data' => $stockPorCategoria->pluck('stock_total')
        ];
    }
}
