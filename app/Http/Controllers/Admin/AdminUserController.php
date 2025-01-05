<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Http\Resources\UserResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class AdminUserController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $users = UserResource::collection(User::all())->resolve();

        return view('admin.users', compact('users')); 
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {    
        // Validação dos dados 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users,name',
            'profile' => 'required|string|in:Institution,Company,Responsible,Student', 
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'account_is_verified' => 'nullable|boolean',  
        ],[
            'name.unique' => 'O nome de utilizador já se encontra em uso',
            'email.unique' => 'O email de utilizador já se encontra em uso',
        ]);
        
        // Se a valicao falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $data = $validator->validated();

        $data['account_is_verified'] = $request->has('account_is_verified') && $request->input('account_is_verified') == '1';

        // Cria a novo utilizador
        $user = User::create($data);
    

    if ($user) {
        // Se a conta não estiver verificada, gera um token e envia o e-mail de verificacao
        if (!$data['account_is_verified']) {
            $token = rand(10000, 99999); 
            $user->update(['token' => $token]);

            // Envia o e-mail de verificacao
            Mail::send('emails.verification', ['token' => $token], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Verificação de E-mail');
            });
        }

            // Da returna para a pagina dos users com uma mensagem de success
            return redirect()->route('admin.users.index')->with('success', 'Utilizador criado com sucesso!');
        } else {
            // Da return para a pagina dos users com uma mensagem de error
            return redirect()->route('admin.users.index')->with('error', 'Erro ao criar utilizador');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Return para a view com os dados
        return view('admin.users.index', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {                
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
            'profile' => 'nullable|string|in:Institution,Company,Responsible,Student,Admin',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);


        // Verifica se a validacao falhou
        if ($validator->fails()) {

            // Passa os erros para a session
            session()->flash('error', 'Erro de validação!');
            session()->flash('validation_errors', $validator->errors()->all());

            // Redireciona de volta com os erros armazenados na session
            return redirect()->back()->withInput();
        }

        // Dados validados
        $validated = $validator->validated();

        // Prepara os dados para atualizar
        $dataToUpdate = [];

        // Verifique se cada campo foi alterado e se sim adiciona os ao array de atualizacao

        if ($validated['name'] != $user->name) {
            $dataToUpdate['name'] = $validated['name'];
        }

        if (!empty($validated['profile']) && $validated['profile'] != $user->profile) {
            $dataToUpdate['profile'] = $validated['profile'];
        }        

        if ($validated['email'] != $user->email) {
            $dataToUpdate['email'] = $validated['email'];
        }

        if (isset($validated['password']) && !empty($validated['password'])) {
            $dataToUpdate['password'] = Hash::make($validated['password']);
        }        

        // Faz a atualizacao
        $update = $user->update($dataToUpdate);

        // Verifica se a atualizacao ocorreu
        if ($update) {

            return redirect()->route('admin.users.index')->with('success', 'Utilizador atualizado com sucesso!');

        } else {
            
            return redirect()->route('admin.users.index')->with('error', 'Erro ao atualizar utilizador');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {    
        // Verifica se o utilizador tem a ruel Admin
        if ($user->profile === 'Admin') {
    
            return redirect()->route('admin.users.index')->with('error', 'Não é permitido apagar um utilizador com cargo de Admin.');
        }
    
        $deleted = $user->delete();
    
        if ($deleted) {
    
            return redirect()->route('admin.users.index')->with('success', 'Utilizador apagado com sucesso!');
        } else {

            return redirect()->route('admin.users.index')->with('error', 'Erro ao apagar utilizador');
        }
    }
}
