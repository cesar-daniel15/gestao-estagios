<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UnitCurricular; 
use App\Models\Course;  
use App\Models\Institution;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UnitResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\InstitutionResource;


class AdminUnitsCurricularsController extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenha as unidades curriculares
        $unitsCurriculars = UnitCurricular::with('course.institution')->get();
        $unitsCurricularResource = UnitResource::collection($unitsCurriculars)->resolve();

        // Obtenha todos os cursos
        $courses = Course::all();
        $coursesResource = CourseResource::collection($courses)->resolve();
    
        // Obtenha todas as instituições
        $institutions = Institution::all();
        $institutionsResource = InstitutionResource::collection($institutions)->resolve();        
        
        // Retorna para a view com as unidades curriculares, cursos e instituições
        return view('admin.units-curriculars', [
            'unitsCurriculars' => $unitsCurricularResource,
            'courses' => $coursesResource, 
            'institutions' => $institutionsResource 
        ]);
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
        //dd($request->all()); // Adicione esta linha para depuração

        // Validação dos dados 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10',
            'ects' => 'required|integer|min:1',
            'course_id' => 'required|exists:courses,id|unique:units_curriculars,course_id', 
        ], [
            'course_id.required' => 'O campo curso é obrigatório',
            'course_id.unique' => 'Este curso já tem uma unidade curricular',
            'course_id.exists' => 'O curso selecionado não é válido',
        ]);
        
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $data = $validator->validated();

        // Cria a nova unidade curricular
        $created = UnitCurricular::create($data);
        
        if ($created) {
            return redirect()->route('admin.units.index')->with('success', 'Unidade Curricular criada com sucesso!');
        } else {
            return redirect()->route('admin.units.index')->with('error', 'Erro ao criar Unidade Curricular');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitCurricular $unitCurricular)
    {
        // Retorna para a view de detalhes da unidade curricular
        return view('admin.units_curriculars.show', compact('unitCurricular'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitCurricular $unitCurricular)
    {


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitCurricular $unitCurricular)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255|required',
            'acronym' => 'string|max:10|required',
            'ects' => 'integer|min:1|required',
        ] , [
            'name.required' => 'O campo nome é obrigatório',
            'acronym.unique' => 'O campo acronimoe é obrigatório.',
            'ects.exists' => 'O campo ects é obrigatório.',
        ]);

        
        // Verifica se a validação falhou
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Dados validados
        $validated = $validator->validated();

        // Prepara os dados para atualizar
        $dataToUpdate = [];

        if ($validated['name'] != $unitCurricular->name) {
            $dataToUpdate['name'] = $validated['name'];
        }

        if ($validated['acronym'] != $unitCurricular->acronym) {
            $dataToUpdate['acronym'] = $validated['acronym'];
        }

        if ($validated['ects'] != $unitCurricular->ects) {
            $dataToUpdate['ects'] = $validated['ects'];
        }

        $update = $unitCurricular->update($dataToUpdate);

        if ($update) {
            return redirect()->route('admin.units.index')->with('success', 'Unidade Curricular atualizada com sucesso!');
        } else {
            return redirect()->route('admin.units.index')->with('error', 'Erro ao atualizar Unidade Curricular');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitCurricular $unitCurricular)
    {
        // Remove uma unidade curricular
        $deleted = $unitCurricular->delete();

        if ($deleted) {
            return redirect()->route('admin.units.index')->with('success', 'Unidade Curricular excluída com sucesso!');
        } else {
            return redirect()->route('admin.units.index')->with('error', 'Erro ao excluir Unidade Curricular');
        }
    }
}
