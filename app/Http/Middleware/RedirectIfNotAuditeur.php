<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuditeur
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si l'auditeur est connecté
        if (!Auth::guard('auditeur')->check()) {
            // Redirige vers la page de login auditeur
            return redirect('/'); // ou '/auditeur/login' si tu as un formulaire dédié
        }

        return $next($request);
    }
}
