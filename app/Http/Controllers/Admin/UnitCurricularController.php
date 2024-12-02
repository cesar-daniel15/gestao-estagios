<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\UnitCurricular;
use App\Models\Course;
use App\Traits\HttpResponses;


use Illuminate\Http\Request;

class UnitCurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HttpResponses;

    public function index()
{
    // Busca as unidades curriculares com os cursos relacionados
    $unitsCurriculares = UnitCurricular::with('course')->get();

    // Busca todos os cursos
    $courses = Course::all();

    // Passa as duas variáveis para a view
    return view('admin.units-curriculars', compact('unitsCurriculares', 'courses'));
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
