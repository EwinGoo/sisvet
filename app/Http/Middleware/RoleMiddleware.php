<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        // Verifica si el usuario tiene alguno de los roles permitidos
        if ($user && in_array($user->rol->rol, $roles)) {
            return $next($request);
        }
        // Si no tiene permiso, redirige o lanza un error
        // return abort(403); // O puedes lanzar un 403: abort(403);
        return redirect('/404');
    }
}
