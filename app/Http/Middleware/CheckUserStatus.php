<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            switch ($user->status) {
                case 'bloqueado':
                    Auth::logout();
                    return redirect()->route('login.index')->withErrors([
                        'error' => 'Seu acesso está bloqueado. Contate o administrador.'
                    ]);

                case 'férias':
                    Auth::logout();
                    return redirect()->route('login.index')->withErrors([
                        'error' => 'Você está de férias e temporariamente sem acesso.'
                    ]);
            }
        }

        return $next($request);
    }
}
