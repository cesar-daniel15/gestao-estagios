<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution; // Import do Model Institution
use App\Http\Resources\UserResource; // Import do Resource



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        // Vai buscar todos os dados as tabelas
        $institutions = Institution::all();
        // ...
        
        // UserResource para formatar os dados antes de enviar para a view
        $formattedInstitutions = UserResource::collection($institutions)->toArray(request()); // Converter para array

        // Enviar os dados para a view
        return view('admin.users', ['allUsers' => $formattedInstitutions]);
        
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
        //
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
