<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UcResponsible; // Import do Model UcResponsible
use App\Http\Resources\UcResponsibleResource; // Import do UcResponsibleResource
use Illuminate\Support\Facades\Validator; // Import do Validator
use App\Traits\HttpResponses;


class UcResponsibleController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
        
        // Ve for uma request do Postman retorna em JSON 
        if ($isPostmanRequest || request()->wantsJson()) {
            return UcResponsibleResource::collection(UcResponsible::all());
        }
    
        $uc_responsibles = UcResponsibleResource::collection(UcResponsible::all())->resolve();

        // Retorna para view com os responsaveis da uc
        // return view('admin.uc-responsibles', compact('uc_responsibles'));
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
