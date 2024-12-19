<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution; 
use App\Models\User; 
use Illuminate\Support\Str; 
use App\Http\Resources\InstitutionResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->profile !== 'Institution') {
            return redirect()->back()->with('error', 'Você não tem permissão para eceder a esta página.');
        }

        $user = Auth::user();

        return view('users.institution.dashboard', compact('user'));
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
        $institution = $user->institution; 
    
        // Validação
        $validator = Validator::make($request->all(), [
            'acronym' => 'required|string|max:10|unique:institutions,acronym' . ($institution ? ',' . $institution->id : ''),
            'phone' => 'required|string|max:11|unique:institutions,phone' . ($institution ? ',' . $institution->id : ''),
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $validator->validated();
    
        if ($institution) {
            // Se a instituicao ja existir faz update 
            $institution->update($data);
    
            // Verifica se o logo foi enviado e faz o upload
            if ($request->hasFile('logo')) {
                // Apaga o logo antigo
                if ($institution->logo && Storage::exists($institution->logo)) {
                    Storage::delete($institution->logo);
                }
                $path = $request->file('logo')->store('images/uploads', 'public');
                $institution->update(['logo' => $path]);
            }
    
            return redirect()->route('institution.profile')->with('success', 'Perfil atualizado com sucesso!');
        } else {
            // Cria uma nova instituicao
            $institution = Institution::create($data);
    
            // Associar a instituicao ao user logado
            $user->id_institution = $institution->id;
            $user->save();
    
            // Verifica se o logo foi enviado e faz o upload
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('images/uploads', 'public');
                $institution->update(['logo' => $path]);
            }
    
            return redirect()->route('institution.profile')->with('success', 'Perfil concluído com sucesso!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $institution = $user->institution ?? null;

        return view('users.institution.profile', compact('user', 'institution'));
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
        $validator = Validator::make($request->all(), [
            'acronym' => 'required|string|max:10',  
            'phone' => 'required|string|max:11|unique:institutions,phone,' . $institution->id,
            'address' => 'required|string|max:255',
            'website' => 'url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
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
    
        // Verifica se cada campo foi alterado e se sim adiciona os ao array de atualizacao
    
        if ($validated['acronym'] != $institution->acronym) {
            $dataToUpdate['acronym'] = $validated['acronym'];
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
    
        if ($request->hasFile('logo')) {
            // Apaga o logo antigo
            if ($institution->logo && Storage::exists($institution->logo)) {
                Storage::delete($institution->logo);
            }
            
            // Faz update do logo
            $path = $request->file('logo')->store('images/uploads', 'public');
            $institution->logo = $path;
        }

        // Faz a atualizacao
        $update = $institution->update($dataToUpdate);
    
        // Verifica se a atualizacao ocorreu
        if ($update) {
            return redirect()->route('institutions.profile')->with('success', 'Perfil atualizado com sucesso!');

        } else {
            return redirect()->route('institutions.profile')->with('error', 'Erro ao atualizar perfiç');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
