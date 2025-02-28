<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution; 
use Illuminate\Support\Str; 
use App\Http\Resources\InstitutionResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;

class AdminInstitutionController extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenha as instituições
        $institutions = Institution::all();

        return view('admin.institutions', [
            'institutions' => InstitutionResource::collection($institutions)->resolve() ?? []
        ]);
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
        // Validação dos dados 
        $validator = Validator::make($request->all(), [
            'acronym' => 'required|string|max:10|unique:institutions,acronym',
            'phone' => 'required|string|max:11|unique:institutions,phone',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ], [
            'acronym.unique' => 'O acronimo da instituição já está em uso.',
            'phone.unique' => 'O telefone da instituição já está em uso.',
        ]);
        
       // Se a valicao falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $data = $validator->validated();

        // Cria a nova instituição
        $institution = Institution::create($data);
    
        if ($institution) {

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('images/uploads', 'public');
                $institution->update(['logo' => $path]);
            }

            // Da return para a pagina das instituicoes com uma mensagem de successo
            return redirect()->route('admin.institutions.index')->with('success', 'Instituição criada com sucesso!');
        } else {

            // Da return para a pagina das instituicoes com uma mensagem de erro
            return redirect()->route('admin.institutions.index')->with('error', 'Erro ao criar instituição');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution)
    {

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
        
        $validator = Validator::make($request->all(), [
            'acronym' => 'string|max:5',
            'phone' => 'nullable|string|size:9|unique:institutions,phone,' . $institution->id,
            'address' => 'string|max:255',
            'website' => 'url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ], [
            'acronym.max' => 'O acronimo não pode ter mais de 5 caracteres.',
            'phone.size' => 'O número de telefone deve ter exatamente 9 caracteres.',
            'phone.unique' => 'Já existe uma instituição com esse número de telefone.',
            'website.url' => 'O endereço do website deve ser uma URL válida.',
            'logo.image' => 'O arquivo da logo deve ser uma imagem.',
            'logo.mimes' => 'A logo deve ser um arquivo de tipo jpeg, png, jpg, gif ou svg.',
            'logo.max' => 'O arquivo da logo não pode ser maior que 2MB.',
        ]);
        
        // Verifica se a validacao falhou
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('logo')) {
            // Apaga o logo antigo
            if ($institution->logo && Storage::disk('public')->exists($institution->logo)) {
                Storage::disk('public')->delete($institution->logo);
            }
    
            // Guarda o novo logo 
            $path = $request->file('logo')->store('images/uploads', 'public');
            $data['logo'] = $path; // Atualiza o caminho no array de dados
        }

        // Faz a atualizacao
        $update = $institution->update($data);
    
        // Verifica se a atualizacao ocorreu
        if ($update) {
            return redirect()->route('admin.institutions.index')->with('success', 'Instituição atualizada com sucesso!');

        } else {
            return redirect()->route('admin.institutions.index')->with('error', 'Erro ao atualizar a instituição');
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
            return redirect()->route('admin.institutions.index')->with('success', 'Instituição excluída com sucesso!');

        }else
        {
            return redirect()->route('admin.institutions.index')->with('error', 'Erro ao excluir a instituição');
        }
    }
}
