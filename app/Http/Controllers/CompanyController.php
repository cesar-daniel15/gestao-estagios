<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company; 
use App\Models\User; 
use Illuminate\Support\Str; 
use App\Http\Resources\CompanyResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->profile !== 'Company') {
            return redirect()->back()->with('error', 'Você não tem permissão para eceder a esta página.');
        }

        $user = Auth::user();

        return view('users.company.dashboard', compact('user'));
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
        $user = Auth::user();
        $company = $user->company; 

        // Validação
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:9|unique:companies,phone' . ($company ? ',' . $company->id : ''),
            'industry' => 'required|string|max:255',
            'brief_description' => 'nullable|max:255',
            'foundation_date' => 'required|date|max:255',
            'address' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'phone.required' => 'O campo telefone é obrigatório',
            'phone.unique' => 'O telefone da empresa já está em uso',
            'phone.max' => 'O campo telefone só pode ter 9 valores',
            'industry.required' => 'O campo indústria é obrigatório',
            'brief_description.max' => 'A descrição breve não pode ter mais de 255 caracteres',
            'foundation_date.required' => 'A data de fundação é obrigatória',
            'foundation_date.date' => 'A data de fundação deve ser uma data válida',
            'address.required' => 'O campo morada é obrigatório',
            'logo.image' => 'O arquivo deve ser uma imagem',
            'logo.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif, svg',
            'logo.max' => 'A imagem não pode ter mais de 2048 KB',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $validator->validated();
    
        if ($company) {
            // Se a empresa ja existir faz update 
            $company->update($data);
    
            // Verifica se o logo foi enviado e faz o upload
            if ($request->hasFile('logo')) {
                // Apaga o logo antigo
                if ($company->logo && Storage::exists($company->logo)) {
                    Storage::delete($company->logo);
                }
                $path = $request->file('logo')->store('images/uploads', 'public');
                $company->update(['logo' => $path]);
            }
    
            return redirect()->route('company.profile')->with('success', 'Perfil atualizado com sucesso!');
        } else {
            // Cria uma nova instituicao
            $company = company::create($data);
    
            // Associar a instituicao ao user logado
            $user->id_company = $company->id;
            $user->save();
    
            // Verifica se o logo foi enviado e faz o upload
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('images/uploads', 'public');
                $company->update(['logo' => $path]);
            }
    
            return redirect()->route('company.profile')->with('success', 'Perfil concluído com sucesso!');
        }
    
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $company = $user->company ?? null;

        return view('users.company.profile', compact('user', 'company'));
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
