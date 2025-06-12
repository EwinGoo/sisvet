<?php

namespace App\Http\Controllers\Backend\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Tienda\NotificacionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = NotificacionModel::where('id_usuario', Auth::id())
            ->orderByRaw('leida ASC, created_at DESC') // Primero las no leídas, luego por fecha
            ->with('producto')
            ->take(5)
            ->get();

        return response()->json($notificaciones);
    }
    public function marcarLeida($id)
    {
        $notificacion = NotificacionModel::find($id);

        if ($notificacion && $notificacion->id_usuario == Auth::id()) {
            $notificacion->update(['leida' => 1]);
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Notificación no encontrada'], 404);
    }

    public function contarNoLeidas()
    {
        $count = NotificacionModel::where('id_usuario', Auth::id())
            ->where('leida', 0)
            ->count();

        return response()->json(['count' => $count]);
    }
}
