<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;  
use App\Models\Institution;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        // Validação das credenciais fornecidas
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Tenta autenticar usando o guard 'institution'
        if (Auth::guard('institution')->attempt($credentials)) {
            return $this->response('Authorized', 200);
        }

        return $this->error('Credenciais inválidas', 401);
    }

    public function logout()
    {
        // Implementar logout se necessário
    }
}
