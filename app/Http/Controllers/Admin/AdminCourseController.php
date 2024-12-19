<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Institution;  
use App\Http\Resources\CourseResource; 
use App\Http\Resources\InstitutionResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;

class AdminCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $courses = Course::with('institution')->get();
        $institutions = Institution::all(); 
    
        $coursesResource = CourseResource::collection($courses)->resolve();
        $institutionsResource = InstitutionResource::collection($institutions)->resolve();

        return view('admin.courses', [
            'courses' => $coursesResource, 
            'institutions' => $institutionsResource
        ]);
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
        // Armazena um novo curso na db

        // Validacao dos dados recebidos
        $validator = Validator::make($request->all(), [
            'institution_id' => 'required|exists:institutions,id', // Validação do ID da instituição
            'name' => 'required|string|max:255|unique:courses,name', // O nome tem que ser unico
            'acronym' => 'required|string|max:10',
        ], [
            'name.unique' => 'O nome do curso já está em uso.',
        ]);

        // Se a valicao falhar
        if ($validator->fails()) {
            // Para requisições normais
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Cria o novo recurso
        $created = Course::create($validator->validated());

        if($created){
            return redirect()->route('admin.courses.index')->with('success', 'Curso criado com sucesso!');
        }
        else{
            return redirect()->route('admin.courses.index')->with('error', 'Erro ao criar curso');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        // Retorna um curso espeficio 

         // Return para a view com os dados
        return view('admin.couses.index', compact('course'));

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
    public function update(Request $request, Course $course)
    {
        // Atualiza o curso existente
        
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'acronym' => 'string|max:10',
            'institution_id' => 'exists:institutions,id',
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {

            session()->flash('error', 'Erro de validação!');
            session()->flash('validation_errors', $validator->errors()->all());
            
            return redirect()->back()->withInput();
        }
    
        // Atualiza o curso com os dados válidos
        $update = $course->update($request->all());
        
        if ($update) {
            return redirect()->route('admin.courses.index')->with('success', 'Curso atualizado com sucesso!');

        } else {
            return redirect()->route('admin.courses.index')->with('error', 'Curso atualizado com sucesso!');
        }

        // Redireciona para a lista de cursos com uma mensagem de sucesso
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Remove um curso da db
        $course = Course::findOrFail($id); 
        $deleted = $course->delete();
    
        // Verifica se foi apagado com sucesso
        if ($deleted) {    
            // Redireciona com mensagem de sucesso
            return redirect()->route('admin.courses.index')->with('success', 'Curso apagado com sucesso!');
        }
    
        return redirect()->route('admin.courses.index')->with('error', 'Erro ao apagar o curso');
    }
}
