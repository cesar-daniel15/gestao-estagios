<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student; 
use App\Models\User; 
use Illuminate\Support\Str; 
use App\Http\Resources\StudentResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->profile !== 'Student') {
            return redirect()->back()->with('error', 'Você não tem permissão para acessar esta página.');
        }

        $user = Auth::user();

        return view('users.student.dashboard', compact('user'));
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
        $user = Auth::user();
        $student = $user->student; 
    
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:15|unique:students,phone',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validação da imagem
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $validator->validated();
    
        // Criação do estudante
        $student = new Student();
        $student->phone = $data['phone'];
        //$student->id_student = $user->id_student; // Associa o estudante à instituição do usuário
    
        // Verifica se uma imagem foi enviada e faz o upload
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('images/uploads', 'public'); // Salva em `storage/app/public/students`
            $student->picture = $path; // Salva o caminho no banco de dados
        }
    
        $student->save();
    
        return redirect()->route('student.profile')->with('success', 'Estudante cadastrado com sucesso!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $student = $user->student ?? null;

        return view('users.student.profile', compact('user', 'student'));
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
        // Obter o estudante pelo ID
        $student = Student::findOrFail($id);
    
        // Validação dos campos
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:15|unique:students,phone,' . $student->id,
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
    
        // Prepara os dados para atualização
        $dataToUpdate = [
            'phone' => $validated['phone'],
        ];
    
        // Verifica se a foto foi enviada e processa o upload
        if ($request->hasFile('picture')) {
            // Remove a foto antiga, se existir
            if ($student->picture && Storage::exists($student->picture)) {
                Storage::delete($student->picture);
            }
    
            // Faz o upload da nova foto
            $path = $request->file('picture')->store('images/uploads', 'public');
            $dataToUpdate['picture'] = $path;
        }
    
        // Realiza a atualização
        $updated = $student->update($dataToUpdate);
    
        // Verifica se a atualização foi bem-sucedida
        if ($updated) {
            return redirect()->route('students.profile')->with('success', 'Estudante atualizado com sucesso!');
        } else {
            return redirect()->route('students.profile')->with('error', 'Erro ao atualizar estudante.');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
