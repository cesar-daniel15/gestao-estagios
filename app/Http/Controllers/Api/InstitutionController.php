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
        
        // Ve for uma request do Postman retorna em JSON 
        if ($isPostmanRequest || request()->wantsJson()) {
            return InstitutionResource::collection(Institution::all());
        }
    
        $institutions = InstitutionResource::collection(Institution::all())->resolve();

        // Retorna para view com as instituicoes
        return view('admin.institutions', compact('institutions'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
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
            'name' => 'required|string|max:255|unique:institutions,name',
            'acronym' => 'required|string|max:10',
            'email' => 'required|email|max:255|unique:institutions,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:11|unique:institutions,phone',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
        ], [
            'name.unique' => 'O nome da instituição já está em uso.',
            'email.unique' => 'O e-mail da instituição já está em uso.',
            'phone.unique' => 'O telefone da instituição já está em uso.',
        ]);
        
        // Se a valicao falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Hash da password
        $data = $validator->validated();
        $data['password'] = bcrypt($data['password']);
    
        // Cria a nova instituição
        $institution = Institution::create($data);
    
        if ($institution) {
            
            // Se for uma Request do Postman retorna em JSON
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('Institution created', 200, new InstitutionResource($institution)); //  200 OK → Utilizado quando uma request é bem sucedida
            }
    
            // Da returna para a pagina das instituicoes com uma mensagem de success
            return redirect()->route('admin.institutions.index')->with('success', 'Instituição criada com sucesso!');
        } else {

            // Se for uma Reuqest do Postman retorna em JSON
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('Institution not created', 400); // 400 Bad Request  → Indica que a request é invalida devido a problemas 
            }
    
            // Da return para a pagina das instituicoes com uma mensagem de error
            return redirect()->route('admin.institutions.index')->with('error', 'Erro ao criar instituição');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution)
    {
        // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
    
        // Ve foi uma request do Postman e retorna os dados em JSON
        if ($isPostmanRequest || request()->wantsJson()) {
            return new InstitutionResource($institution);
        }

        // Return para a view com os dados
        return view('admin.institutions.index', compact('institution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institution $institution)
    {
        // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
        
        // Validação dos dados recebidos para atualização
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8', 
            'phone' => 'required|string|max:11',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
        ]);
        // Verifica se a validação falhou
        if ($validator->fails()) {
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->error('Validation failed', 422, $validator->errors());
            }
            
            // Passa os erros de validação para a sessão
            session()->flash('error', 'Erro de validação!');
            session()->flash('validation_errors', $validator->errors()->all());
    
            // Redireciona de volta com os erros armazenados na sessão
            return redirect()->back()->withInput();
        }
    
        // Dados validados
        $validated = $validator->validated();
    
        // Prepara os dados para atualização
        $dataToUpdate = [];
    
        // Verifique se cada campo foi alterado e se sim, adicione ao array de atualização
        if ($validated['name'] != $institution->name) {
            $dataToUpdate['name'] = $validated['name'];
        }
    
        if ($validated['acronym'] != $institution->acronym) {
            $dataToUpdate['acronym'] = $validated['acronym'];
        }
    
        if ($validated['email'] != $institution->email) {
            $dataToUpdate['email'] = $validated['email'];
        }
    
        if ($validated['phone'] != $institution->phone) {
            $dataToUpdate['phone'] = $validated['phone'];
        }
    
        if ($validated['address'] != $institution->address) {
            $dataToUpdate['address'] = $validated['address'];
        }
    
        if ($validated['website'] != $institution->website) {
            $dataToUpdate['website'] = $validated['website'];
        }
    
        if ($validated['logo'] != $institution->logo) {
            $dataToUpdate['logo'] = $validated['logo'];
        }
    
        // Atualiza a senha apenas se ela foi fornecida e diferente
        if (!empty($validated['password']) && $validated['password'] != $institution->password) {
            $dataToUpdate['password'] = bcrypt($validated['password']);
        }
    
        // Verifica se existem dados para atualização
        if (empty($dataToUpdate)) {
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('No data to update', 200);
            }
            return redirect()->route('admin.institutions.index')->with('info', 'Nenhuma alteração foi feita.');
        }
    
        // Realiza a atualização
        $update = $institution->update($dataToUpdate);
    
        // Verifica se a atualização foi bem-sucedida
        if ($update) {
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('Institution updated successfully', 200, new InstitutionResource($institution));
            }
            return redirect()->route('admin.institutions.index')->with('success', 'Instituição atualizada com sucesso.');
        } else {
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
