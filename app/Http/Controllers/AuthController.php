<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;  
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Password; 

class AuthController extends Controller
{
    use HttpResponses;

    public function register(Request $request)
    {
        try {
            $registerUserData = $request->validate([
                'name' => 'required|string|unique:users,name',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|min:8',
                'profile' => 'required|in:Institution,Company,Responsible,Student,Admin',
            ], [
                'name.unique' => 'O nome já está em uso. Escolha outro nome.',
                'email.unique' => 'Este e-mail já está associado a uma conta.',
                'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
                'profile.required' => 'O perfil é obrigatório.',
            ]);

            $token = rand(10000, 99999);

            $user = User::create([
                'name' => $registerUserData['name'],
                'email' => $registerUserData['email'],
                'password' => Hash::make($registerUserData['password']),
                'profile' => $registerUserData['profile'],
                'account_is_verified' => false,
                'token' => $token,
                'last_login' => Carbon::now()
            ]);

            Mail::send('emails.verification', ['token' => $token], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Verificação de E-mail');
            });

            return redirect()->route('verify-account')->with('success', 'Verifique o seu e-mail para confirmar o registo.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return redirect()->route('register')->with('error', implode(' ', $errors))
            ->withInput();
        } catch (\Exception $e) {
            return redirect()->route('register')->with('error', 'Ocorreu um erro ao criar a conta. Por favor, tente novamente.')
            ->withInput();
        }
    }

    public function login(Request $request)
    {
        $loginUserData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required||string|min:8',
        ]);

        $user = User::where('email', $loginUserData['email'])->first();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Algo deu errado, tente novamente.')
            ->withInput();
        }

        if (!Hash::check($loginUserData['password'], $user->password)) {
            return redirect()->route('login')->with('error', 'Password incorreta, tente novamente.')
            ->withInput();
        }

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        $user->update(['last_login' => Carbon::now()]);

        Auth::login($user);

        return redirect()->route('admin.dashboard')->with('success', 'Login realizado com sucesso!');
    }

    public function logout(Request $request)
    {
        Auth::logout(); 
        return redirect()->route('login'); 
    }

    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => 'required|numeric|digits:5', 
        ]);

        $user = User::where('token', $request->token)->first();

        if (!$user) {
            return redirect()->route('verify-account')->with('error', 'Código de verificação inválido.');
        }

        $user->update([
            'account_is_verified' => true,
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard')->with('success', 'Conta verificada com sucesso!');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'O e-mail não foi encontrado.']);
        }

        $token = Password::createToken($user);

        Mail::send('emails.password-reset', ['token' => $token, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Redefinição de Password');
        });

        return back()->with('success', 'Enviamos um link de redefinição da sua password para o seu e-mail!');
    }

    
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }    

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                $user->tokens()->delete();

                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Sua senha foi redefinida com sucesso!')
            : back()->withErrors(['email' => [__($status)]]);
    }

}  
