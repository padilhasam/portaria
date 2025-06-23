<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user || $user->tipo !== 'administrador') {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
