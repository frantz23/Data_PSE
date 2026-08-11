<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsDonor
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Vérifier si l'utilisateur est connecté et possède un compte bailleur actif
        if (!auth()->check() || !auth()->user()->isDonor()) {
            // Redirection avec un message d'erreur si non autorisé
            return redirect()->route('login')
                ->with('error', "Accès refusé. Cet espace est réservé aux bailleurs partenaires.");
        }
        return $next($request);
    }
}
