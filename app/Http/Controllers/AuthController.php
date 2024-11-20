<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;  
use App\Models\User;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        
    }
    public function logout()
    {
        // Implementar logout se necessário
    }
}
