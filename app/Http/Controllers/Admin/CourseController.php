<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course; // Import do Model Course
use App\Http\Resources\CourseResource; // Import do Resource
use Illuminate\Support\Facades\Validator; // Import do Validator
use App\Traits\HttpResponses;

class CourseController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CourseResource::collection(Course::all());
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

        // Verifica se a requisição vem do Postman
        $isPostmanRequest = str_contains(request()->header('User-Agent'), 'Postman');

        // Validacao dos dados recebidos
        $validator = Validator::make($request->all(), [
            'institution_id' => 'required|exists:institutions,id', // Validação do ID da instituição
            'name' => 'required|string|max:255|unique:courses,name', // O nome tem que ser unicos
            'acronym' => 'required|string|max:10',
        ], [
            'name.unique' => 'O nome do curso já está em uso.',
        ]);

        // Se a valicao falhar
        if ($validator->fails()) {

            // Para Postman ou JSON request
            if ($isPostmanRequest || request()->wantsJson()) {
                return $this->error('Validation failed', 422, $validator->errors());
            }
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
        return new CourseResource($course);
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
        // Validacao dos dados recebidos para atualizacao
        $validator = Validator::make($request->all(), [
            'institution_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10',
        ]);

        // Verifica se a validacao falhou
        if ($validator->fails()) {
            return $this->error('Validation failed', 422, $validator->errors());
        }

        // Verifica se a validacao funcionou
        $validated = $validator->validated();

        // Faz o Update
        $update = $course->update([
            'institution_id' => $validated['institution_id'],
            'name' => $validated['name'],
            'acronym' => $validated['acronym'],
        ]);

        if($update){
            return $this->response('Course updated successfully', 200, new CourseResource($course->load('institution')));
        }
        else{
            return $this->response('Institution not updated', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Remove um curso da db

        $deleted = $course->delete();

        // Verificar se foi apagado
        if($deleted){
            return $this->response('Course deleted successfully', 200);
        }else
        {
            return $this->response('Course not deleted', 400);
        }
    }
}
