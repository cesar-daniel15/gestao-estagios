<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Institution;  // Importando o modelo Institution
use App\Http\Resources\CourseResource;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recupera os cursos com as instituições relacionadas
        $courses = Course::with('institution')->get();
    
        // Aplica o resource para formatação
        $courses = CourseResource::collection($courses)->resolve();
    
        // Retorna para a view com os cursos
        return view('admin.courses', compact('courses'));
    }

    // App\Models\Course.php
    public function institution()
    {
        return $this->belongsTo(Institution::class);
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
        // Validação dos dados recebidos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10',
            'institution_id' => 'required|exists:institutions,id',  // Valida se a instituição existe
            'description' => 'nullable|string|max:1000',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Criação do curso, incluindo o ID da instituição
        Course::create([
            'name' => $request->input('name'),
            'acronym' => $request->input('acronym'),
            'institution_id' => $request->input('institution_id'), // Inclui o institution_id
            'description' => $request->input('description'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redireciona para a lista de cursos com mensagem de sucesso
        return redirect()->route('admin.courses.index')->with('success', 'Curso criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Recupera o curso e as instituições para a edição
        $course = Course::findOrFail($id);
        $institutions = Institution::all();
        
        return view('admin.courses.edit', compact('course', 'institutions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10',
            'institution_id' => 'required|exists:institutions,id',  // Verifica se a instituição existe
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Atualiza o curso
        $course = Course::findOrFail($id);
        $course->update($request->all());

        return redirect()->route('admin.courses.index')->with('success', 'Curso atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Remove o curso
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Curso excluído com sucesso!');
    }
}
