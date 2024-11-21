<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Institution;  // Importando o modelo Institution
use App\Http\Resources\CourseResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\HttpResponses;


class CourseController extends Controller
{
    use HttpResponses;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('institution')->get();
        
        $institutions = Institution::all(); // Carrega todas as instituições
    
        return view('admin.courses', ['courses' => $courses, 'institutions' => $institutions]);
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
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        // Verifica se a request vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
    
        // Ve foi uma request do Postman e retorna os dados em JSON
        if ($isPostmanRequest || request()->wantsJson()) {
            return new CourseResource($course);
        }

        // Return para a view com os dados
        return view('admin.couses.index', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        // Verifica se a requisição vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
        
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10',
            'institution_id' => 'required|exists:institutions,id', // Verifica se a instituição existe
            'description' => 'nullable|string|max:1000',
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->error('Validation failed', 422, $validator->errors());
            }
    
            // Se não for request JSON, envia os erros via sessão
            session()->flash('error', 'Erro de validação!');
            session()->flash('validation_errors', $validator->errors()->all());
            return redirect()->back()->withInput();
        }
    
        // Atualiza o curso com os dados válidos
        $course->update($request->all());
    
        // Se for uma Request do Postman retorna em JSON
        if ($isPostmanRequest || request()->wantsJson()) {
            return $this->response('Course updated successfully', 200, new CourseResource($course));
        }
    
        // Redireciona para a lista de cursos com uma mensagem de sucesso
        return redirect()->route('admin.courses.index')->with('success', 'Curso atualizado com sucesso!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        // Verifica se a requisição vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
        
        // Deleta o curso
        $deleted = $course->delete();
    
        // Verifica se foi deletado com sucesso
        if ($deleted) {
            // Se for uma requisição do Postman retorna em JSON
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->response('Course deleted successfully', 200);
            }
    
            // Redireciona com mensagem de sucesso
            return redirect()->route('admin.courses.index')->with('success', 'Curso excluído com sucesso!');
        }
    
        // Se não foi possível deletar o curso
        if ($isPostmanRequest || request()->wantsJson()) {
            return $this->response('Course not deleted', 400); // 400 Bad Request
        }
    
        // Se não foi request JSON, envia a mensagem via sessão
        return redirect()->route('admin.courses.index')->with('error', 'Erro ao excluir o curso');
    }
    
}