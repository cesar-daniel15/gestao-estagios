<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student; // Certifique-se de ter o modelo Student configurado
use Illuminate\Support\Str; 


class StudentController extends Controller
{
    public function index()
    {
        // Carregar lista de alunos do banco de dados
        $students = Student::all();
        return view('students.index', compact('students')); // Certifique-se de ter uma view students.index
    }

    public function store(Request $request)
    {
        // Validação e criação do aluno
        $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url',
        ]);

        // Criação do aluno no banco de dados
        Student::create([
            'name' => $request->name,
            'acronym' => $request->acronym,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'website' => $request->website,
        ]);

        return redirect()->route('students.index')->with('success', 'Aluno registrado com sucesso!');
    }

    public function edit($id)
    {
        // Carregar aluno pelo ID
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student')); // Certifique-se de ter uma view students.edit
    }

    public function update(Request $request, $id)
    {
        // Validação e atualização do aluno
        $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10',
            'email' => 'required|email|unique:students,email,' . $id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url',
        ]);

        // Atualização do aluno no banco de dados
        $student = Student::findOrFail($id);
        $student->update([
            'name' => $request->name,
            'acronym' => $request->acronym,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'website' => $request->website,
        ]);

        return redirect()->route('students.index')->with('success', 'Aluno atualizado com sucesso!');
    }

    public function destroy($id)
    {
        // Exclusão do aluno pelo ID
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Aluno excluído com sucesso!');
    }
}
