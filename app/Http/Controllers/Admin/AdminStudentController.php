<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student; // Import do Model Student
use Illuminate\Support\Str; 
use App\Http\Resources\StudentResource; // Import do Student
use Illuminate\Support\Facades\Validator; // Import do Validator
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use App\Models\Institution; // Import do Model Institution
use App\Models\Course; // Import do Model Course
use App\Models\UnitCurricular; // Import do Model UnitCurricular
use App\Http\Resources\UnitResource; // Import do UnitResource
use App\Http\Resources\InstitutionResource;
use App\Http\Resources\CourseResource;

class AdminStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['ucs' => function ($query) {
            $query->withPivot('lective_year'); 
        }, 'ucs.course.institution'])->get();
        
        $unitCurriculars = UnitCurricular::all();
        $institutions = Institution::all();
        $courses = Course::all();

        return view('admin.students', [
            'students' => StudentResource::collection($students)->resolve() ?? [],
            'unitCurriculars' => UnitResource::collection($unitCurriculars)->resolve() ?? [],
            'institutions' => InstitutionResource::collection($institutions)->resolve() ?? [],
            'courses' => CourseResource::collection($courses)->resolve() ?? []
        ]);

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
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'name' => '|string|max:255',
            'phone' => 'required|string|max:9|unique:students,phone'. ($student ? ',' . $student->id : ''),
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'assigned_internship_id' => 'nullable|exists:internships,id', 
        ], [
            'name.string' => 'O nome deve ser uma string',
            'phone.required' => 'O campo telefone é obrigatório',
            'phone.max' => 'O telefone não pode ter mais de 9 valores',
            'phone.unique' => 'O telefone já está em uso',
            'picture.image' => 'O arquivo deve ser uma imagem',
            'picture.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif, svg',
            'picture.max' => 'A imagem não pode ter mais de 2048 KB',
            'assigned_internship_id.exists' => 'O estágio atribuído não existe',
        ]);

        // Se a validação falhar, retorna com erros
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Cria o novo estudante
        $student = Student::create($data);

        // Verifica se o estudante foi criado com sucesso
        if ($student) {
            // Verifica se o estudante tem uma foto (picture) e a armazena
            if ($request->hasFile('picture')) {
                $path = $request->file('picture')->store('images/uploads', 'public');
                $student->update(['picture' => $path]); // Atualiza o caminho da foto no banco
            }

            // Caso o estudante seja criado com sucesso, redireciona com sucesso
            return redirect()->route('admin.students.index')->with('success', 'Estudante criado com sucesso!');
        } else {
            // Caso ocorra erro ao criar o estudante
            return redirect()->route('admin.students.index')->with('error', 'Erro ao criar estudante');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        // Return para a view com os dados
        return view('admin.students.index', compact('student'));

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
    public function update(Request $request, Student $student)
    {
        // Validação dos dados 
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'phone' => 'string|max:9|unique:students,phone,' . $student->id, 
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'assigned_internship_id' => 'nullable|exists:internships,id',
        ], [
            'name.string' => 'O nome deve ser uma string',
            'phone.string' => 'O telefone deve ser uma string',
            'phone.max' => 'O telefone não pode ter mais de 9 valores',
            'phone.unique' => 'O telefone do responsável já está em uso',
            'picture.image' => 'O arquivo deve ser uma imagem',
            'picture.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif, svg',
            'picture.max' => 'A imagem não pode ter mais de 2048 KB',
            'assigned_internship_id.exists' => 'O estágio atribuído não existe',
        ]);
    
        // Se a validação falhar, retorna com erros
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $validator->validated();
    
        // Verifica se há uma foto do estudante (picture)
        if ($request->hasFile('picture')) {
            // Apaga a foto antiga
            if ($student->picture && Storage::disk('public')->exists($student->picture)) {
                Storage::disk('public')->delete($student->picture);
            }
    
            // Armazena a nova foto
            $path = $request->file('picture')->store('images/uploads', 'public');
            $data['picture'] = $path; // Atualiza o caminho da foto
        }
    
        // Faz a atualização dos dados do estudante
        $update = $student->update($data);
    
        // Verifica se a atualização ocorreu com sucesso
        if ($update) {
            return redirect()->route('admin.students.index')->with('success', 'Aluno atualizado com sucesso!');
        } else {
            return redirect()->route('admin.students.index')->with('error', 'Erro ao atualizar o aluno');
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // Remove uma instituicao da db     

        $deleted = $student->delete();   

        // Verificar se foi apagada
        if($deleted){
            return redirect()->route('admin.students.index')->with('success', 'Aluno excluído com sucesso!');

        }else
        {
            return redirect()->route('admin.students.index')->with('error', 'Erro ao excluir o aluno');
        }
    }

    public function associateStudentToUc(Request $request, $studentId)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'uc_id' => 'required|exists:units_curriculars,id', 
            'lective_year' => 'required|string', 
        ], [
            'uc_id.required' => 'O campo unidade curricular é obrigatório.',
            'uc_id.exists' => 'A unidade curricular informada não existe.',
            'lective_year.required' => 'O campo ano letivo é obrigatório.',
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Encontrar o aluno
        $student = Student::findOrFail($studentId);

        // Verifica se a unidade curricular já está associada ao aluno
        if ($student->ucs()->where('uc_id', $request->uc_id)->exists()) {
            return redirect()->route('admin.students.index')->with('info', 'O aluno já está associado a esta unidade curricular');
        }
    
        // Associar a unidade curricular ao aluno com o ano letivo
        $student->ucs()->attach($request->uc_id, ['lective_year' => $request->lective_year]);
    
        return redirect()->route('admin.students.index')->with('success', 'Unidade Curricular associada com sucesso ao aluno');
    }
}
