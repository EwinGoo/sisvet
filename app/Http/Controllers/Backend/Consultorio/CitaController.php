<?php

namespace App\Http\Controllers\Backend\Consultorio;

use App\Http\Controllers\Controller;
use App\Models\Consultorio\CitaModel;
use App\Models\MascotaModel;
use App\Models\PropietarioModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CitaController extends Controller
{
    public function __construct()
    {
        $this->title = 'Gestión de Citas';
        $this->page = 'admin-cita';
        $this->pageURL = 'admin-cita';
        $this->area = 'Consultorio';
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $data = CitaModel::getCitas(
                $request->get('query'),
                $request->get('fecha')
            );
            return response()->json(['data' => $data], 200);
        }

        $this->data['propietarios'] = PropietarioModel::selectRaw("*, CONCAT_WS(' ', nombre, paterno, IFNULL(materno, '')) as nombre_completo")
            ->get();
        // dd($this->data['propietarios']);
        return $this->render("consultorio.cita.index");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_propietario' => 'required|exists:propietarios,id_propietario',
            'id_mascota' => 'required|exists:mascotas,id_mascota',
            'fecha_hora' => 'required|date|after:now',
            'tipo_consulta' => 'required|in:Consulta general,Vacunación,Urgencia,Cirugía,Estética,Otro',
            'duracion' => 'required|integer|min:15|max:120',
            'motivo' => 'required|string|max:500',
        ], [
            'fecha_hora.after' => 'La fecha y hora debe ser futura',
            'id_mascota.required' => 'Debe seleccionar una mascota',
            'id_propietario.required' => 'Propietario es requerido',
            'fecha_hora.required' => 'El campo es requerido',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Validar disponibilidad del médico
        $existeCita = CitaModel::where('id_medico', Auth::id())
            ->where('fecha_hora', '<=', Carbon::parse($request->fecha_hora)->addMinutes($request->duracion))
            ->whereRaw('DATE_ADD(fecha_hora, INTERVAL duracion MINUTE) >= ?', [$request->fecha_hora])
            ->where('estado', '!=', 'Cancelada')
            ->exists();

        if ($existeCita) {
            return response()->json([
                'message' => 'Ya tiene una cita programada en ese horario',
                'status' => 409
            ], 409);
        }

        $cita = CitaModel::create([
            'id_propietario' => $request->id_propietario,
            'id_mascota' => $request->id_mascota,
            'id_medico' => Auth::id(), // Asignar automáticamente el médico logueado
            'fecha_hora' => $request->fecha_hora,
            'duracion' => $request->duracion,
            'tipo_consulta' => $request->tipo_consulta,
            'motivo' => $request->motivo,
            'estado' => 'Pendiente',
            'notas' => $request->notas,
        ]);

        return response()->json([
            'message' => 'Cita creada exitosamente',
            'cita' => $cita,
            'status' => 201
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $cita = CitaModel::where('id_cita', $id)
            ->where('id_medico', Auth::id()) // Solo el médico dueño puede editar
            ->first();

        if (!$cita) {
            return response()->json([
                'message' => 'Cita no encontrada',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'fecha_hora' => 'required|date|after:now',
            'tipo_consulta' => 'required|in:Consulta general,Vacunación,Urgencia,Cirugía,Estética,Otro',
            'duracion' => 'required|integer|min:15|max:120',
            'motivo' => 'required|string|max:500',
            'motivo_cancelacion' => 'required_if:estado,Cancelada|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Validar disponibilidad si cambió la fecha/hora
        if ($request->fecha_hora != $cita->fecha_hora || $request->duracion != $cita->duracion) {
            $existeCita = CitaModel::where('id_medico', Auth::id())
                ->where('id_cita', '!=', $id)
                ->where('fecha_hora', '<=', Carbon::parse($request->fecha_hora)->addMinutes($request->duracion))
                ->whereRaw('DATE_ADD(fecha_hora, INTERVAL duracion MINUTE) >= ?', [$request->fecha_hora])
                ->where('estado', '!=', 'Cancelada')
                ->exists();

            if ($existeCita) {
                return response()->json([
                    'message' => 'Ya tiene una cita programada en ese horario',
                    'status' => 409
                ], 409);
            }
        }

        $cita->update($request->all());

        return response()->json([
            'message' => 'Cita actualizada exitosamente',
            'cita' => $cita,
            'status' => 200
        ], 200);
    }

    public function destroy($id)
    {
        $cita = CitaModel::where('id_cita', $id)
            ->where('id_medico', Auth::id())
            ->first();

        if (!$cita) {
            return response()->json([
                'message' => 'Cita no encontrada',
                'status' => 404
            ], 404);
        }

        $cita->delete();

        return response()->json([
            'message' => 'Cita eliminada exitosamente',
            'status' => 200
        ], 200);
    }

    public function getMascotas($propietarioId)
    {
        $mascotas = MascotaModel::where('id_propietario', $propietarioId)
            ->select(['id_mascota', 'nombre_mascota', 'id_animal'])
            ->with('animal:id_animal,animal')
            ->get();

        return response()->json([
            'mascotas' => $mascotas,
            'status' => 200
        ], 200);
    }

    public function cambiarEstado(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'estado' => 'required|in:Confirmada,Completada,Cancelada',
            'motivo_cancelacion' => [
                'nullable',
                Rule::requiredIf(function () use ($request) {
                    return $request->estado === 'Cancelada';
                }),
                'string',
                'max:255'
            ],
        ], [
            'motivo_cancelacion.required_if' => 'El motivo de cancelación es requerido',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $cita = CitaModel::where('id_cita', $id)
            ->where('id_medico', Auth::id())
            ->first();

        if (!$cita) {
            return response()->json([
                'message' => 'Cita no encontrada',
                'status' => 404
            ], 404);
        }

        $cita->update([
            'estado' => $request->estado,
            'motivo_cancelacion' => $request->motivo_cancelacion
        ]);

        return response()->json([
            'message' => 'Estado de cita actualizado',
            'status' => 200
        ], 200);
    }
    public function calendario(Request $request)
    {
        // Verifica si es una solicitud AJAX para el calendario
        if ($request->ajax() && $request->isMethod('get')) {
            $start = $request->get('start');
            $end = $request->get('end');

            $citas = CitaModel::where('id_medico', Auth::id())
                ->whereBetween('fecha_hora', [$start, $end])
                ->with(['mascota', 'propietario'])
                ->get()
                ->map(function ($cita) {
                    return [
                        'id' => $cita->id_cita,
                        'title' => $cita->mascota->nombre_mascota . ' - ' . $cita->tipo_consulta,
                        'start' => $cita->fecha_hora,
                        'end' => Carbon::parse($cita->fecha_hora)->addMinutes($cita->duracion),
                        'className' => $this->getEventClass($cita->estado),
                        'extendedProps' => [
                            'estado' => $cita->estado,
                            'propietario' => $cita->propietario->nombre . ' ' . $cita->propietario->paterno . ' ' . $cita->propietario->materno,
                            'mascota' => $cita->mascota->nombre_mascota,
                            'tipo_consulta' => $cita->tipo_consulta,
                            'motivo' => $cita->motivo,
                        ]
                    ];
                });

            return response()->json($citas);
        }
        // dd(123);

        // Si no es AJAX, renderiza la vista normal
        $this->title = 'Calendario de Citas';
        $this->page = 'admin-calendario';
        $this->pageURL = 'admin-calendario';
        $this->area = 'Consultorio';
        return $this->render("consultorio.cita.calendario");
    }

    public function updateFecha(Request $request, $id)
    {
        $cita = CitaModel::where('id_cita', $id)
            ->where('id_medico', Auth::id())
            ->first();

        if (!$cita) {
            return response()->json([
                'message' => 'Cita no encontrada',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'start' => 'required|date',
            'end' => 'required|date|after:start',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Calcular duración en minutos
        $duracion = Carbon::parse($request->end)->diffInMinutes($request->start);

        // Validar disponibilidad
        $existeCita = CitaModel::where('id_medico', Auth::id())
            ->where('id_cita', '!=', $id)
            ->where('fecha_hora', '<=', $request->end)
            ->whereRaw('DATE_ADD(fecha_hora, INTERVAL duracion MINUTE) >= ?', [$request->start])
            ->where('estado', '!=', 'Cancelada')
            ->exists();

        if ($existeCita) {
            return response()->json([
                'message' => 'Ya tiene una cita programada en ese horario',
                'status' => 409
            ], 409);
        }

        $cita->update([
            'fecha_hora' => $request->start,
            'duracion' => $duracion
        ]);

        return response()->json([
            'message' => 'Cita actualizada exitosamente',
            'status' => 200
        ], 200);
    }

    private function getEventClass($estado)
    {
        switch ($estado) {
            case 'Confirmada':
                return 'bg-gradient-success';
            case 'Pendiente':
                return 'bg-gradient-warning';
            case 'Completada':
                return 'bg-gradient-info';
            case 'Cancelada':
                return 'bg-gradient-danger';
            default:
                return 'bg-gradient-primary';
        }
    }

    public function proximosEventos(Request $request)
    {
        $limit = $request->get('limit', 5); // Por defecto 5 eventos

        $eventos = CitaModel::with(['mascota', 'propietario'])
            ->where('id_medico', Auth::id())
            ->where('fecha_hora', '>=', now())
            ->where('estado', '!=', 'Cancelada')
            ->orderBy('fecha_hora', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($cita) {
                return [
                    'id' => $cita->id_cita,
                    'titulo' => $cita->mascota->nombre_mascota . ' - ' . $cita->tipo_consulta,
                    'fecha' => $cita->fecha_hora,
                    'icono' => $this->getIconoPorTipo($cita->tipo_consulta),
                    'estado' => $cita->estado
                ];
            });

        return response()->json($eventos);
    }

    private function getIconoPorTipo($tipoConsulta)
    {
        $iconos = [
            'Consulta general' => 'medical_services',
            'Vacunación' => 'vaccines',
            'Urgencia' => 'emergency',
            'Cirugía' => 'local_hospital',
            'Estética' => 'spa',
            'Otro' => 'event'
        ];

        return $iconos[$tipoConsulta] ?? 'event';
    }


    public function datosProductividad(Request $request)
    {
        $rango = $request->get('rango', 'semanal'); // semanal, mensual, anual

        $datos = DB::table('citas')
            ->select(
                DB::raw('COUNT(*) as total_citas'),
                DB::raw('SUM(CASE WHEN estado = "Completada" THEN 1 ELSE 0 END) as completadas'),
                DB::raw('YEAR(fecha_hora) as year'),
                DB::raw('MONTH(fecha_hora) as month'),
                DB::raw('WEEK(fecha_hora, 3) as week'),
                DB::raw('DAY(fecha_hora) as day')
            )
            ->where('id_medico', Auth::id())
            ->when($rango === 'semanal', function ($query) {
                return $query->whereBetween('fecha_hora', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])
                    ->groupBy('week');
            })
            ->when($rango === 'mensual', function ($query) {
                return $query->whereBetween('fecha_hora', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ])
                    ->groupBy('day');
            })
            ->when($rango === 'anual', function ($query) {
                return $query->whereBetween('fecha_hora', [
                    now()->startOfYear(),
                    now()->endOfYear()
                ])
                    ->groupBy('month');
            })
            ->orderBy('fecha_hora')
            ->get();

        return response()->json([
            'labels' => $datos->map(function ($item) use ($rango) {
                return $this->formatearEtiqueta($item, $rango);
            }),
            'datasets' => [
                [
                    'label' => 'Citas Totales',
                    'data' => $datos->pluck('total_citas'),
                    'tension' => 0.4,
                    'borderColor' => '#2dce89',
                    'backgroundColor' => 'rgba(45, 206, 137, 0.1)'
                ],
                [
                    'label' => 'Citas Completadas',
                    'data' => $datos->pluck('completadas'),
                    'tension' => 0.4,
                    'borderColor' => '#11cdef',
                    'backgroundColor' => 'rgba(17, 205, 239, 0.1)'
                ]
            ]
        ]);
    }

    private function formatearEtiqueta($item, $rango)
    {
        switch ($rango) {
            case 'semanal':
                return "Semana {$item->week}";
            case 'mensual':
                return "Día {$item->day}";
            case 'anual':
                return DateTime::createFromFormat('!m', $item->month)->format('F');
        }
    }
}
