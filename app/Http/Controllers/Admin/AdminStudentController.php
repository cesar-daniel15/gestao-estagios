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


class AdminStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenha as instituições
        $students = Student::all();

        return view('admin.students', [
            'students' => StudentResource::collection($students)->resolve() ?? []
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
            'phone' => 'required|string|max:11|unique:students,phone',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'assigned_internship_id' => 'nullable|exists:internships,id', // A validação do estágio
        ], [
            'phone.unique' => 'O telefone do estudante já está em uso.',
            'assigned_internship_id.exists' => 'O estágio atribuído não existe.',
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
            'phone' => 'string|max:11|unique:students,phone,' . $student->id, // Para garantir que o telefone do estudante não seja único, exceto para o próprio estudante
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'assigned_internship_id' => 'nullable|exists:internships,id', // Se houver um estágio a ser atribuído ao estudante
        ], [
            'phone.unique' => 'O telefone do estudante já está em uso.',
            'assigned_internship_id.exists' => 'O estágio atribuído não existe.',
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            // Passa os erros para a session
            session()->flash('error', 'Erro de validação!');
            session()->flash('validation_errors', $validator->errors()->all());
    
            // Redireciona de volta com os erros armazenados na session
            return redirect()->back()->withInput();
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
            return redirect()->route('admin.students.index')->with('success', 'Estudante atualizado com sucesso!');
        } else {
            return redirect()->route('admin.students.index')->with('error', 'Erro ao atualizar o estudante');
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
}
