<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company; 
use App\Http\Resources\CompanyResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;

class AdminCompanyController extends Controller
{

    use HttpResponses;  // Usando o trait HttpResponses

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = CompanyResource::collection(Company::all())->resolve();

        // Retorna para view com as empresas
        // return view('admin.companies', compact('companies'));
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
        
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            if ($file->isValid()) {
                $path = $file->store('images/uploads', 'public'); // Guarda na pasta public
                $data['logo'] = $path; 
            }
        }

        // Cria a nova empresa
        $company = Company::create($data);
    
        if ($company) {
            // Da returna para a pagina das instituicoes com uma mensagem de success
            // return redirect()->route('admin.companies.index')->with('success', 'Empresa criada com sucesso!');

        } else {
            // Da return para a pagina das instituicoes com uma mensagem de error
            // return redirect()->route('admin.companies.index')->with('error', 'Erro ao criar empresa');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
