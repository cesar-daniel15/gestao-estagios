<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UcResponsible; // Import do Model UcResponsible
use Illuminate\Support\Str; 
use App\Http\Resources\UcResponsibleResource; // Import do UcResponsibleResource
use Illuminate\Support\Facades\Validator; // Import do Validator
use App\Traits\HttpResponses; // Import do trait HttpResponses
use Illuminate\Support\Facades\Storage;

class AdminUcResponsibleController extends Controller

{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $UcResponsibles = UcResponsible::all();
        
            return view('admin.uc-responsibles', [
                'UcResponsibles' =>UcResponsibleResource::collection($UcResponsibles)->resolve() ?? []
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
        // Validação dos dados enviados via POST
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',  // Apenas validação para o campo phone
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validação para a imagem (se for enviada)
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Se uma imagem foi enviada, faz o upload
        $picturePath = null;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('uc_responsibles_pictures', 'public');
        }
    
        // Cria o responsável da UC
        $uc_responsible = UcResponsible::create([
            'phone' => $request->phone,
            'picture' => $picturePath,  // Armazena o caminho da imagem
        ]);

        // Verifica se a criação foi bem-sucedida
        if ($uc_responsible) {
            return redirect()->route('admin.uc_responsibles.index')->with('success', 'Responsável da UC criado com sucesso!');
        } else {
            return redirect()->route('admin.uc_responsibles.index')->with('error', 'Erro ao criar responsável da UC.');
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Encontra o responsável da UC pelo ID
        $ucResponsible = UcResponsible::findOrFail($id);
        
        // Retorna a resposta com os dados do responsável da UC
        return view('admin.uc_responsibles.index', compact('UcResponsible'));
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
    public function update(Request $request, UcResponsible $UcResponsible)
    {

        // Validação dos dados enviados via PUT/PATCH
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'uc_id' => 'required|exists:uc,id', // Verifica se o id da UC existe
        ]);

        // Se a validação falhar, retorna os erros
        if ($validator->fails()) {

            // Passa os erros para a session
            session()->flash('error', 'Erro de validação!');
            session()->flash('validation_errors', $validator->errors()->all());

            return redirect()->back()->withInput();
        }

        $data = $validator->validated();

        // Atualiza os dados do responsável da UC
        $ucResponsible->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'picture' => $request->picture,
            'uc_id' => $request->uc_id,
        ]);

        // Faz a atualizacao
        $update = $institution->update($data);

        // Verifica se a criação foi bem-sucedida
        if ($uc_responsible) {
            return redirect()->route('admin.uc_responsibles.index')->with('success', 'Responsável da UC criado com sucesso!');
        } else {
            return redirect()->route('admin.uc_responsibles.index')->with('error', 'Erro ao atualizar o responsável da UC.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UcResponsible $ucResponsible)
    {
        // Remove o responsável da UC
        $delete = $ucResponsible->delete();

        // Retorna uma resposta de sucesso
        if ($delete) {  // Verifica se o delete foi bem-sucedido
            return redirect()->route('admin.uc_responsibles.index')->with('success', 'Responsável da UC excluído com sucesso!');
        } else {
            return redirect()->route('admin.uc_responsibles.index')->with('error', 'Erro ao excluir o responsável da UC.');
        }
    }

}
