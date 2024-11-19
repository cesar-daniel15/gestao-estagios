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
    public function destroy($id)
    {
        // Verifica se a requisição vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');
    
        // Recupera o curso
        $course = Course::findOrFail($id);
    
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