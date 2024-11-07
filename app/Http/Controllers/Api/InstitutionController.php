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
        // Armazena um novo recurso na db

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
            return $this->response('Institution created', 200, $created);
        }
        else{
            return $this->error('Institution not create', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retorna um recurso específico pelo ID

        return new InstitutionResource(Institution::where('id',$id)->first());
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
    public function update(Request $request, string $id)
    {
        // Atualiza um recurso existente
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(string $id)
    {
        // Remove um recurso da db     
    }
}
