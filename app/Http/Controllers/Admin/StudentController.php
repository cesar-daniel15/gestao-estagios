<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student; // Import do Model Student
use App\Http\Resources\StudentResource; // Import do Student
use Illuminate\Support\Facades\Validator; // Import do Validator
use App\Traits\HttpResponses;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
        
        // Ve for uma request do Postman retorna em JSON 
        if ($isPostmanRequest || request()->wantsJson()) {
            return StudentResource::collection(Student::all());
        }
    
        $students = StudentResource::collection(Student::all())->resolve();

        // Retorna para view com os alunos
        // return view('admin.students', compact('students'));
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
