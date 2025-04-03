<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MascotaModel;
use App\Models\Tienda\VentaModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $this->data['total_mascotas'] = MascotaModel::count();
        $this->data['porcentaje_crecimiento'] = $this->getPorcentajeCrecimiento();
        $this->data['total_vendido'] = VentaModel::whereDate('fecha_venta', Carbon::today())->sum('total_venta');
        $this->data['porcentaje_vendido'] = $this->getPorcentajeVendido();
        $this->data['mascotas_registradas_hoy'] = MascotaModel::whereDate('created_at', Carbon::today())->count();

        $ventasPorMes = VentaModel::selectRaw('DATE_FORMAT(fecha_venta, "%b") as mes, SUM(total_venta) as total')
            ->whereBetween('fecha_venta', [Carbon::now()->subMonths(9), Carbon::now()])
            ->groupBy('mes')
            ->orderByRaw('MIN(fecha_venta)')
            ->pluck('total', 'mes');

        $this->data['labels'] = $ventasPorMes->keys();  // Meses
        $this->data['data'] = $ventasPorMes->values();  // Totales de ventas
        // dd($this->data['labels'],$this->data['data']);

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
}
