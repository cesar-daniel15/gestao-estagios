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
        // Validacao dos dados
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

            // Evia email para verificar conta
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
        // Validacao dos dados
        $loginUserData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required||string|min:8',
        ]);

        // Verifica se existe um user com esse email
        $user = User::where('email', $loginUserData['email'])->first();
        
        // Se nao existir
        if (!$user) {
            return redirect()->route('login')->with('error', 'Algo deu errado, tente novamente.')
            ->withInput();
        }

        // Verifica se a password esta correta
        if (!Hash::check($loginUserData['password'], $user->password)) {
            return redirect()->route('login')->with('error', 'Password incorreta, tente novamente.')
            ->withInput();
        }

        // Cria um token para o user
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken; 
        // Update do campo last_login
        $user->update(['last_login' => Carbon::now()]);

        // Faz login com o user
        Auth::login($user);

        // Redirect dependendo do profile de cada user
        switch ($user->profile) {
            case 'Admin':
                return redirect()->route('admin.dashboard')->with('success', 'Login realizado com sucesso!');
            case 'Student':
                return redirect()->route('student.dashboard')->with('success', 'Login realizado com sucesso!');
            case 'Responsible':
                return redirect()->route('responsible.dashboard')->with('success', 'Login realizado com sucesso!');
            case 'Company':
                return redirect()->route('company.dashboard')->with('success', 'Login realizado com sucesso!');
            case 'Institution':
                return redirect()->route('institution.dashboard')->with('success', 'Login realizado com sucesso!');
        }
    }

    public function logout(Request $request)
    {
        // Faz o logout e manda para a view de login
        Auth::logout(); 
        return redirect()->route('login'); 
    }

    public function verifyToken(Request $request)
    {
        // Validacao do token enserido no input
        $request->validate([
            'token' => 'required|numeric|digits:5', 
        ]);

        // Procura o user apartir do token
        $user = User::where('token', $request->token)->first();

        // Se o token for invalido
        if (!$user) {
            return redirect()->route('verify-account')->with('error', 'Código de verificação inválido.');
        }

        // Marca a conta como verificada
        $user->update([
            'account_is_verified' => true,
        ]);

        // Faz login com o user
        Auth::login($user);

        // Redereciona para a view para atualizar o perfil
        switch ($user->profile) {
            case 'Student':
                return redirect()->route('student.profile')->with('success', 'Login realizado com sucesso!');
            case 'Responsible':
                return redirect()->route('responsible.profile')->with('success', 'Login realizado com sucesso!');
            case 'Company':
                return redirect()->route('company.profile')->with('success', 'Login realizado com sucesso!');
            case 'Institution':
                return redirect()->route('institution.profile')->with(['success' => 'Login realizado com sucesso!', 'info' => 'Atualize o seu perfil para concluir o processo!']);
        }
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
