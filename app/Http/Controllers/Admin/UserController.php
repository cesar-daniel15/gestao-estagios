<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Http\Resources\UserResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
       // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
        
       // Ve for uma request do Postman retorna em JSON 
        if ($isPostmanRequest || request()->wantsJson()) {
            return UserResource::collection(User::all());
        }
    

        $users = UserResource::collection(User::all())->resolve();

       // Retorna para view com os Users
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
        // Verifica se a requisição vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
    
        // Validação dos dados 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users,name',
            'profile' => 'required|string|in:Institution,Company,Responsible,Student', 
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'name.unique' => 'O nome de utilizador já está em uso',
            'email.unique' => 'O telefone da instituição já está em uso',
        ]);
        
       // Se a valicao falhar
        if ($validator->fails()) {

            // Para Postman ou JSON request
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->error('Validation failed', 422, $validator->errors());
            }
            // Para requisições normais
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $data = $validator->validated();

        // Cria a nova instituição
        $user = User::create($data);
    
        if ($user) {
            
            // Se for uma Request do Postman retorna em JSON
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('User created', 200, new UserResource($user)); //  200 OK → Utilizado quando uma request é bem sucedida
            }
    
            // Da returna para a pagina das instituicoes com uma mensagem de success
            return redirect()->route('admin.users.index')->with('success', 'Utilizador criada com sucesso!');
        } else {

            // Se for uma Reuqest do Postman retorna em JSON
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('User not created', 400); // 400 Bad Request  → Indica que a request é invalida devido a problemas 
            }
    
            // Da return para a pagina das instituicoes com uma mensagem de error
            return redirect()->route('admin.users.index')->with('error', 'Erro ao criar utilizador');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
    
        // Ve foi uma request do Postman e retorna os dados em JSON
        if ($isPostmanRequest || request()->wantsJson()) {
            return new UserResource($user);
        }

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
        // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
                
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
            'profile' => 'nullable|string|in:Institution,Company,Responsible,Student,Admin',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);


        // Verifica se a validacao falhou
        if ($validator->fails()) {
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->error('Validation failed', 422, $validator->errors());
            }

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
            // Se for uma Request do Postman Retorna em Json
            if ($isPostmanRequest || request()->wantsJson()) {

                return $this->response('User updated successfully', 200, new UserResource($user)); //  200 OK → Utilizado quando uma request é bem sucedida

            }
            return redirect()->route('admin.users.index')->with('success', 'Utilizador atualizado com sucesso!');

        } else {
            if ($isPostmanRequest || request()->wantsJson()) {

                return $this->response('User not updated', 400); // 400 Bad Request  → Indica que a request é invalida devido a problemas 

            }
            
            return redirect()->route('admin.users.index')->with('error', 'Erro ao atualizar utilizador');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User -Agent'), 'Postman');
    
        // Verifica se o utilizador tem a ruel Admin
        if ($user->profile === 'Admin') {
            // Retorna uma resposta de erro se for uma requisição do Postman
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->error('Não é permitido apagar um utilizador com perfil Admin.', 403);
            }
    
            return redirect()->route('admin.users.index')->with('error', 'Não é permitido apagar um utilizador com cargo de Admin.');
        }
    
        $deleted = $user->delete();
    
        if ($deleted) {
            // Ve for uma request do Postman retorna em JSON
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('User  deleted successfully', 200); // 200 OK → Utilizado quando uma request é bem sucedida
            }
    
            return redirect()->route('admin.users.index')->with('success', 'Utilizador apagado com sucesso!');
        } else {
            // Ve for uma request do Postman retorna em JSON
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('User  not deleted', 400); // 400 Bad Request → Indica que a request é invalida devido a problemas 
            }
            return redirect()->route('admin.users.index')->with('error', 'Erro ao apagar utilizador');
        }
    }
}
