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
        // Armazena uma nova instituicao na db

        // Validação dos dados recebidos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:institutions,name', // O nome tem quer ser unico
            'acronym' => 'required|string|max:10',
            'email' => 'required|email|max:255|unique:institutions,email', // O email tem de ser unico
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:11|unique:institutions,phone', // O telemovel tem de ser unico
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
        ]);

        // Verifica se a validação falhou
        if ($validator->fails()) {
            return $this->error('Data Invalid', 422, $validator->errors());
        }

        // Hash da password
        $data = $validator->validated();
        $data['password'] = bcrypt($data['password']);

        // Verifica se a instituicao ja existe
        if (Institution::where('name', $request->name)->exists()) {
            return $this->error('Institution already exists', 409);
        }

        // Cria o novo recurso
        $created = Institution::create($validator->validated());

        if($created){
            //return redirect()->route('institutions.index')->with('success', 'Institution created successfully')->with('new_institution', $created);
            //return $this->response('Institution created', 200, $created);

            return redirect()->route('institutions.index')->with('success', 'Instituição criada com sucesso!');
        }
        else{
            //return $this->error('Institution not create', 400);
            return redirect()->route('institutions.index')->with('error', 'Erro ao criar instituição.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution)
    {
        // return new InstitutionResource($institution);

        // Manda dados para a view
        return view('admin.institutions', compact('institution'));
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
        // Validação dos dados recebidos para atualização
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:institutions,name,' . $id, // Ignora a exclusividade do ID
            'acronym' => 'required|string|max:10',
            'email' => 'required|email|max:255|unique:institutions,email,' . $id, // Ignora a exclusividade do ID
            'password' => 'nullable|string|min:8', // Permite que a password seja opcional
            'phone' => 'required|string|max:11|unique:institutions,phone,' . $id, // Ignora a exclusividade do ID
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|string|max:255',
        ]);

        // Verifica se a validation falhou
        if ($validator->fails()) {
            return $this->error('Validation failed', 422, $validator->errors());
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
            return $this->response('Institution updated successfully', 200, new InstitutionResource($institution));
        }
        else{
            return $this->response('Institution not updated', 400);
        }

    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(Institution $institution)
    {
        // Remove uma instituicao da db     

        $deleted = $institution->delete();

        // Verificar se foi apagada
        if($deleted){
            // return $this->response('Institution deleted successfully', 200);
            return redirect()->route('institutions.index')->with('success', 'Instituição excluída com sucesso!');

        }else
        {
           // return $this->response('Institution not deleted', 400);
            return redirect()->route('institutions.index')->with('error', 'Erro ao excluir a instituição.');
        }
    }
}
