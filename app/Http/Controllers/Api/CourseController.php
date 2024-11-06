<?php

namespace App\Http\Controllers\Api;

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
        // Validacao dos dados recebidos
        $validator = Validator::make($request->all(), [
            'institution_id' => 'required|exists:institutions,id', // Validação do ID da instituição
            'name' => 'required|string|max:255|unique:courses,name',
            'acronym' => 'required|string|max:10',
        ]);

        // Verifica se a validacao falhou
        if ($validator->fails()) {
            return $this->error('Data Invalid', 422, $validator->errors());
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
    public function show(string $id)
    {
        // Retorna um curso espeficio pelo ID
        return new CourseResource(Course::where('id',$id)->first());
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
