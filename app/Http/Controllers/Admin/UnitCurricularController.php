<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\UnitCurricular;
use App\Models\Course;


use Illuminate\Http\Request;

class UnitCurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HttpResponses;

    public function index()
    {
        $unitsCurriculares = UnitCurricular::with('courses')->get();

        $courses = Course::all();
        //return view('admin.units-curriculars', ['unitsCurriculares' => $unitsCurriculares, 'courses' => $courses]);
        return view('admin.units-curriculars' , compact('units-curriculars'));
        
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
