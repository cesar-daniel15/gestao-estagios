<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution; // Import do Model Institution
use Illuminate\Support\Str; 

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $institutions = Institution::all();

        // Retorna a view com as instituicoes
        return view('admin.institutions', compact('institutions'));

         // Retorna todas as instituições como JSON, para uso em requisições API
        return response()->json($institutions, 200);
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
        // Validacao dos dados recebidos 
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10',
            'email' => 'required|email|unique:institutions',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        // Gera um token
        $validatedData['token'] = Str::random(5);

        // Cria uma nova instituicao
        $institution = Institution::create($validatedData);

        // Retorna a nova instituicao 
        return redirect()->route('institutions.index')->with('success', 'Instituição registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retorna um recurso específico pelo ID
        $institution = Institution::find($id);

        // Verifica se encontroy
        if (!$institution) {
            return response()->json(['message' => 'Institution not found'], 404);
        }

        // Return da instituicao
        return response()->json($institution, 200);
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
         // Validação dos dados recebidos 
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'acronym' => 'nullable|string|max:10',
            'email' => 'nullable|email|unique:institutions,email,' . $id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        // Procura pelo ID
        $institution = Institution::find($id);

        // Verifica se existe
        if (!$institution) {
            return response()->json(['message' => 'Institution not found'], 404);
        }

        // Atualiza os campos
        $institution->update(array_filter($validatedData)); // Remove campos nulos

        // Retorna a instituição atualizada
        return redirect()->route('institutions.index')->with('success', 'Instituição atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(string $id)
    {
        // Remove um recurso da db
        // Procura a instituicao pelo ID
        $institution = Institution::find($id);

        // Verifica se a instituicao foi encontrada
        if (!$institution) {
            return response()->json(['message' => 'Institution not found'], 404);
        }

        // Remove a instituicao da db
        $institution->delete();

        // Return da mensagem
        return response()->json(['message' => 'Institution deleted successfully'], 200);
        
    }
}
