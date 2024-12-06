<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UnitCurricular; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;  


class AdminUnitsCurricularsController extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenha as unidades curriculares
        $unitsCurriculars = UnitCurricular::all(); // Pode fazer uma consulta mais específica se necessário
    
        // Obtenha todos os cursos
        $courses = Course::all();
    
        // Retorna para a view com as unidades curriculares e cursos
        return view('admin.units-curriculars', [
            'unitsCurriculars' => $unitsCurriculars,
            'courses' => $courses // Adicione a variável courses aqui
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
            'acronym' => 'required|string|max:10|unique:units_curriculars,acronym',
            'ects' => 'required|integer|min:1',
            'course_id' => 'required|exists:courses,id', // Adicione esta linha
        ], [
            'acronym.unique' => 'O acrônimo da unidade curricular já está em uso.',
            'course_id.required' => 'O campo curso é obrigatório.',
            'course_id.exists' => 'O curso selecionado não é válido.',
        ]);
        
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $data = $validator->validated();
    
        // Cria a nova unidade curricular
        $unitCurricular = UnitCurricular::create($data);
        
        if ($unitCurricular) {
            return redirect()->route('admin.units.index')->with('success', 'Unidade Curricular criada com sucesso!');
        } else {
            return redirect()->route('admin.units.index')->with('error', 'Erro ao criar Unidade Curricular');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitsCurricular $unitCurricular)
    {
        // Retorna para a view de detalhes da unidade curricular
        return view('admin.units_curriculars.show', compact('unitCurricular'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitsCurricular $unitCurricular)
    {
        // Retorna para a view de edição
        return view('admin.units_curriculars.edit', compact('unitCurricular'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitsCurricular $unitCurricular)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10|unique:units_curriculars,acronym,' . $unitCurricular->id,
            'ects' => 'required|integer|min:1',
        ]);

        
        // Verifica se a validação falhou
        if ($validator->fails()) {
            // Passa os erros para a sessão
            session()->flash('error', 'Erro de validação!');
            session()->flash('validation_errors', $validator->errors()->all());
            
            // Redireciona de volta com os erros armazenados na sessão
            return redirect()->back()->withInput();
        }

        // Dados validados
        $validated = $validator->validated();

        // Prepara os dados para atualizar
        $dataToUpdate = [];

        // Verifica se cada campo foi alterado e, se sim, adiciona ao array de atualização
        if ($validated['course_id'] != $unitCurricular->course_id) {
            $dataToUpdate['course_id'] = $validated['course_id'];
        }

        if ($validated['name'] != $unitCurricular->name) {
            $dataToUpdate['name'] = $validated['name'];
        }

        if ($validated['acronym'] != $unitCurricular->acronym) {
            $dataToUpdate['acronym'] = $validated['acronym'];
        }

        if ($validated['ects'] != $unitCurricular->ects) {
            $dataToUpdate['ects'] = $validated['ects'];
        }

        // Atualiza apenas se houver mudanças
        if (!empty($dataToUpdate)) {
            $update = $unitCurricular->update($dataToUpdate);

            if ($update) {
                return redirect()->route('admin.units.index')->with('success', 'Unidade Curricular atualizada com sucesso!');
            } else {
                return redirect()->route('admin.units.index')->with('error', 'Erro ao atualizar Unidade Curricular');
            }
        }

        // Nenhuma alteração detectada
        return redirect()->route('admin.units.index')->with('info', 'Nenhuma alteração foi feita.');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitsCurricular $unitCurricular)
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
