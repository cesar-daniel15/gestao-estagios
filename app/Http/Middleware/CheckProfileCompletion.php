<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompletion
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o usuário está autenticado
        if (Auth::check()) {
            $user = Auth::user();

            // Verifica se o perfil é 'Company' e se id_company é nulo
            if ($user->profile === 'Company' && is_null($user->id_company)) {
                if ($request->isMethod('post') || $request->routeIs('company.profile')) {
                    return $next($request);
                }
                return redirect()->route('company.profile')->with('info', 'Por favor, atualize o seu perfil!');
            }

            // Verifica se o perfil é 'Student' e se id_student é nulo
            if ($user->profile === 'Student' && is_null($user->id_student)) {
                if ($request->isMethod('post') || $request->routeIs('student.profile')) {
                    return $next($request);
                }
                return redirect()->route('student.profile')->with('info', 'Por favor, atualize o seu perfil!');
            }

            // Verifica se o perfil é 'Responsible' e se id_responsible é nulo
            if ($user->profile === 'Responsible' && is_null($user->id_responsible)) {
                if ($request->isMethod('post') || $request->routeIs('responsible.profile')) {
                    return $next($request);
                }
                return redirect()->route('responsible.profile')->with('info', 'Por favor, atualize o seu perfil!');
            }

            // Verifica se o perfil é 'Institution' e se id_institution é nulo
            if ($user->profile === 'Institution' && is_null($user->id_institution)) {
                if ($request->isMethod('post') || $request->routeIs('institution.profile')) {
                    return $next($request);
                }
                return redirect()->route('institution.profile')->with('info', 'Por favor, atualize o seu perfil!');
            }
        }

        return $next($request);
    }
}