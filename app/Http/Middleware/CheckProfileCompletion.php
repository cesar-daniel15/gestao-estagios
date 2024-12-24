<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o usuário está autenticado
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->profile === 'Company' && is_null($user->id_company)) {
                if (!$request->routeIs('company.profile')) {
                    return redirect()->route('company.profile')->with('info', 'Por favor, atualize o seu perfil!');
                }
            }

            if ($user->profile === 'Student' && is_null($user->id_student)) {
                if (!$request->routeIs('student.profile')) {
                    return redirect()->route('student.profile')->with('info', 'Por favor, atualize o seu perfil!');
                }
            }

            if ($user->profile === 'Responsible' && is_null($user->id_responsible)) {
                if (!$request->routeIs('responsible.profile')) {
                    return redirect()->route('responsible.profile')->with('info', 'Por favor, atualize o seu perfil!');
                }
            }

            if ($user->profile === 'Institution' && is_null($user->id_institution)) {
                if (!$request->routeIs('institution.profile')) {
                    return redirect()->route('institution.profile')->with('info', 'Por favor, atualize o seu perfil!');
                }
            }
        }

        return $next($request);
    }
}
