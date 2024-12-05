<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class CheckVerifiedAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->account_is_verified === false && !$request->is('verify-account')) {
                return redirect()->route('verify-account')
                    ->with('error', 'Por favor, verifique sua conta antes de continuar.');
            }
        }

        return $next($request);
    }
}
