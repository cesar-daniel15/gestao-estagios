<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution; // Import do Model Institution
use Illuminate\Support\Str; 
use App\Http\Resources\InstitutionResource; // Import do Resource

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        //$institutions = Institution::all();
        //return view('admin.institutions', ['institutions' => $institutions]);

        return InstitutionResource::collection(Institution::all());
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
