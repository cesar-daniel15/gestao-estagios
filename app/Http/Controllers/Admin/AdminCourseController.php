<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\CourseResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use App\Models\Institution;  

class AdminCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $courses = Course::with('institution')->get();
        
        $institutions = Institution::all(); 
    
        return view('admin.courses', ['courses' => $courses, 'institutions' => $institutions]);

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

        // Verifica se o nome do curso ja existe
        if (Course::where('name', $request->name)->exists()) {
            return $this->error('Course already exists', 409);
        }

        // Cria o novo recurso
        $created = Course::create($validator->validated());

        if($created){
            return $this->response('Course created', 201, new CourseResource($created->load('institution')));
        }
        else{
            return $this->error('Course not create', 400);
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
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10',
            'institution_id' => 'required|exists:institutions,id', // Verifica se a instituição existe
            'description' => 'nullable|string|max:1000',
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            session()->flash('error', 'Erro de validação!');
            session()->flash('validation_errors', $validator->errors()->all());
            return redirect()->back()->withInput();
        }
    
        // Atualiza o curso com os dados válidos
        $course->update($request->all());
    
        // Redireciona para a lista de cursos com uma mensagem de sucesso
        return redirect()->route('admin.courses.index')->with('success', 'Curso atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Remove um curso da db

        // Verifica se a requisição vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
        
        // Deleta o curso
        $deleted = $course->delete();
    
        // Verifica se foi deletado com sucesso
        if ($deleted) {    
            // Redireciona com mensagem de sucesso
            return redirect()->route('admin.courses.index')->with('success', 'Curso excluído com sucesso!');
        }
    
        return redirect()->route('admin.courses.index')->with('error', 'Erro ao excluir o curso');
    }
}
