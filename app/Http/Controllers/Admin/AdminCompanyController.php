<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company; 
use App\Http\Resources\CompanyResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;

class AdminCompanyController extends Controller
{

    use HttpResponses;  

    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $companies = CompanyResource::collection(Company::all())->resolve();

        // Retorna para view com as empresas
        return view('admin.companies', compact('companies'));
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
            'phone' => 'required|string|max:11|unique:companies.phone',
            'industry' => 'required|string|max:255',
            'brief_description' => 'nullable|max:255',
            'address' => 'string|max:255',
            'foundation_date' => 'date',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ], [
            'phone.unique' => 'O telefone da empresa já está em uso',
        ]);
        
        // Se a valicao falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $data = $validator->validated();

        // Cria a nova empresa
        $company = Company::create($data);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            if ($file->isValid()) {
                $path = $file->store('images/uploads', 'public'); 
                $data['logo'] = $path; 
            }
        }
    
        if ($company) {
            // Da return para a pagina das instituicoes com uma mensagem de success
            return redirect()->route('admin.companies.index')->with('success', 'Empresa criada com sucesso!');

        } else {
            // Da return para a pagina das instituicoes com uma mensagem de error
            return redirect()->route('admin.companies.index')->with('error', 'Erro ao criar empresa');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return view('admin.companies.index', compact('companies'));
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
    public function update(Request $request, Company $company)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|string|size:9|unique:companies,phone,' . $company->id, 
            'industry' => 'string|max:255',
            'address' => 'string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ], [
            'phone.size' => 'O número de telefone deve ter exatamente 9 caracteres.',
            'phone.unique' => 'Já existe uma empresa com esse número de telefone.',
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
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
    
            // Guarda o novo logo 
            $path = $request->file('logo')->store('images/uploads', 'public');
            $data['logo'] = $path; // Atualiza o caminho no array de dados
        }

        // Faz a atualizacao
        $update = $company->update($data);
    
        // Verifica se a atualizacao ocorreu
        if ($update) {
            return redirect()->route('admin.companies.index')->with('success', 'Empresa atualizada com sucesso!');

        } else {
            return redirect()->route('admin.companies.index')->with('error', 'Erro ao atualizar a empresa');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $deleted = $company->delete();

        // Verificar se foi apagada
        if($deleted){
            return redirect()->route('admin.companies.index')->with('success', 'Instituição excluída com sucesso!');

        }else
        {
            return redirect()->route('admin.companies.index')->with('error', 'Erro ao excluir a instituição');
        }
    }
}
