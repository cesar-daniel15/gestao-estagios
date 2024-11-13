<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution; // Import do Model Institution
use Illuminate\Support\Str; 
use App\Http\Resources\InstitutionResource; // Import do Resource
use Illuminate\Support\Facades\Validator; // Import do Validator
use App\Traits\HttpResponses;

class InstitutionController extends Controller
{
    use HttpResponses;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
        
        // Ve foi uma request do Postman
        if ($isPostmanRequest || request()->wantsJson()) {
            // Retorna em JSON 
            return InstitutionResource::collection(Institution::all());
        }
    
        // Retorna a view com as instituicoes
        $institutions = InstitutionResource::collection(Institution::all())->resolve();
        return view('admin.institutions', compact('institutions'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retorna um form para criar um novo recurso
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verifica se a requisição vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
    
        // Validação dos dados recebidos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:institutions,name',
            'acronym' => 'required|string|max:10',
            'email' => 'required|email|max:255|unique:institutions,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:11|unique:institutions,phone',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Hash da password
        $data = $validator->validated();
        $data['password'] = bcrypt($data['password']);
    
        // Cria a nova instituição
        $institution = Institution::create($data);
    
        if ($institution) {
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('Institution created', 200, new InstitutionResource($institution));
            }
    
            // Redireciona para a lista de instituições com uma mensagem de sucesso
            return redirect()->route('admin.institutions.index')->with('success', 'Instituição criada com sucesso!');
        } else {
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('Institution not created', 400);
            }
    
            // Redireciona para a lista de instituições com uma mensagem de erro
            return redirect()->route('admin.institutions.index')->with('error', 'Erro ao criar instituição.');
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution)
    {
        // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
    
        // Ve foi uma request do Postman
        if ($isPostmanRequest || request()->wantsJson()) {
            // Retorna os dados em JSON
            return new InstitutionResource($institution);
        }

        // Manda os dados para a view
        return view('admin.institutions.index', compact('institution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Retorna um form para editar um recurso
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institution $institution)
    {
        // Atualiza uma instituicao existente
        
        // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
        
        // Validação dos dados recebidos para atualização
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:institutions,name,' . $institution->id, // Ignora a exclusividade do ID
            'acronym' => 'required|string|max:10',
            'email' => 'required|email|max:255|unique:institutions,email,' . $institution->id, // Ignora a exclusividade do ID
            'password' => 'nullable|string|min:8', // Permite que a password seja opcional
            'phone' => 'required|string|max:11|unique:institutions,phone,' . $institution->id, // Ignora a exclusividade do ID
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
        ]);

        // Verifica se a validation falhou
        if ($validator->fails()) {

            // Ve foi uma request do Postman
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->error('Validation failed', 422, $validator->errors());
            }
    
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verifica se a validacao falhou
        $validated = $validator->validated();

        // Faz o Update
        $update = $institution->update([
            'name' => $validated['name'],
            'acronym' => $validated['acronym'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'website' => $validated['website'],
            'logo' => $validated['logo'],
        ]);

        if($update){
            // Ve foi uma request do Postman
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('Institution updated successfully', 200, new InstitutionResource($institution));
            }
        }
        else{
            // Ve foi uma request do Postman
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('Institution not updated', 400);
            }
            
            return redirect()->route('admin.institutions.index')->with('error', 'Erro ao atualizar a instituição.');
        }
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(Institution $institution)
    {
        // Remove uma instituicao da db     

        // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');

        $deleted = $institution->delete();

        // Verificar se foi apagada
        if($deleted){
            // Ve foi uma request do Postman
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('Institution deleted successfully', 200);
            }

            return redirect()->route('admin.institutions.index')->with('success', 'Instituição excluída com sucesso!');

        }else
        {
            // Ve foi uma request do Postman
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('Institution not deleted', 400);
            }
            return redirect()->route('admin.institutions.index')->with('error', 'Erro ao excluir a instituição.');
        }
    }
}
