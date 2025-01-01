<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UnitCurricular;
use App\Models\UcResponsible;
use App\Models\UcToStudent;
use App\Models\UcToResponsible; // Importando o modelo correto
use App\Models\User;
use App\Models\Notification;
use App\Models\Student;

 
use Illuminate\Support\Str; 
use App\Http\Resources\UcResponsibleResource; 
use App\Http\Resources\StudentResource; 
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ResponsibleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->profile !== 'Responsible') {
            return redirect()->back()->with('error', 'Você não tem permissão para eceder a esta página.');
        }

        $user = Auth::user();

        return view('users.responsible.dashboard', compact('user'));
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
        $responsible = $user->responsible;

        // Validação
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:9|unique:uc_responsibles,phone' . ($responsible ? ',' . $responsible->id : ''),
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'phone.required' => 'O campo telefone é obrigatório',
            'phone.string' => 'O telefone deve ser uma string',
            'phone.max' => 'O telefone não pode ter mais de 9 caracteres',
            'phone.unique' => 'O telefone já está em uso',
            'picture.image' => 'O arquivo deve ser uma imagem',
            'picture.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif',
            'picture.max' => 'A imagem não pode ter mais de 2048 KB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($responsible) {
            // Atualiza o registro existente
            $responsible->update($data);

            // Verifica se a imagem foi enviada e faz o upload
            if ($request->hasFile('picture')) {
                if ($responsible->picture && Storage::exists($responsible->picture)) {
                    Storage::delete($responsible->picture);
                }
                $path = $request->file('picture')->store('images/uploads', 'public');
                $responsible->update(['picture' => $path]);
            }

            return redirect()->route('responsible.profile')->with('success', 'Perfil atualizado com sucesso!');
        } else {
            // Cria um novo registro
            $responsible = UcResponsible::create($data);

            // Associa o responsável ao utilizador logado
            $user->id_responsible = $responsible->id;
            $user->save();

            if ($request->hasFile('picture')) {
                $path = $request->file('picture')->store('images/uploads', 'public');
                $responsible->update(['picture' => $path]);
            }

            return redirect()->route('responsible.profile')->with('success', 'Perfil criado com sucesso!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $responsible = $user->responsible ?? null;
        $unitsCurricular = UnitCurricular::all(); 

        return view('users.responsible.profile', compact('user', 'responsible', 'unitsCurricular'));
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
    $responsible = Responsible::findOrFail($id);

    // Validação dos dados
    $validator = Validator::make($request->all(), [
        'phone' => 'required|string|max:15|unique:responsibles,phone,' . $responsible->id,
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Verifica se a validação falhou
    if ($validator->fails()) {
        // Passa os erros para a sessão e redireciona
        session()->flash('error', 'Erro de validação!');
        session()->flash('validation_errors', $validator->errors()->all());

        return redirect()->back()->withInput();
    }

    // Dados validados
    $validated = $validator->validated();

    // Prepara os dados para atualização
    $dataToUpdate = [];

    // Atualiza apenas os campos que mudaram
    if (isset($validated['phone']) && $validated['phone'] !== $responsible->phone) {
        $dataToUpdate['phone'] = $validated['phone'];
    }

    if ($request->hasFile('picture')) {
        // Remove a imagem antiga, se existir
        if ($responsible->picture && Storage::exists($responsible->picture)) {
            Storage::delete($responsible->picture);
        }

        // Faz o upload da nova imagem
        $path = $request->file('picture')->store('images/uploads', 'public');
        $dataToUpdate['picture'] = $path;
    }

    // Verifica se há algo para atualizar
    if (!empty($dataToUpdate)) {
        $responsible->update($dataToUpdate);

        return redirect()->route('responsibles.profile')->with('success', 'Perfil atualizado com sucesso!');
    }

    return redirect()->route('responsibles.profile')->with('info', 'Nenhuma alteração foi feita.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $responsible = Responsible::findOrFail($id);

        if ($responsible->picture && Storage::exists($responsible->picture)) {
            Storage::delete($responsible->picture);
        }

        $responsible->delete();

        return redirect()->route('responsibles.index')->with('success', 'Responsável removido com sucesso!');
    }


    public function dashboard()
    {
        // Pegando todos os alunos com estágio atribuído
        $students = \App\Models\UcToStudent::whereNotNull('internship_id')->get();
    
        // Se não houver alunos com estágio, retornamos um gráfico vazio
        if ($students->isEmpty()) {
            $chartData = [];
        } else {
            // Agrupar alunos por estágio (internship_id) e contar a quantidade de alunos em cada estágio
            $chartData = $students->groupBy('internship_id')->map(function ($group) {
                return $group->count();
            })->toArray();
        }
    
        return view('responsible.dashboard', compact('chartData'));
    }
    


    public function listStudents()
    {
        // Obtém o usuário logado
        $user = Auth::user();
        
        // Verifica se o usuário é um responsável
        if ($user->profile !== 'Responsible') {
            return redirect()->back()->with('error', 'Você não tem permissão para acessar esta página.');
        }
        
        // Supondo que o responsável tenha uma relação com as unidades curriculares que ele gere
        $responsible = $user->responsible; // Obtém o responsável associado ao usuário
        
        if (!$responsible) {
            return redirect()->back()->with('error', 'Responsável não encontrado.');
        }

        // Buscar unidades curriculares associadas ao responsável
        $unitCurricularIds = UcToResponsible::where('uc_responsible_id', $responsible->id)  // Alteração para o campo correto
                                    ->pluck('uc_id');
        
        // Obter os alunos associados a essas unidades curriculares
        $students = UcToStudent::whereIn('uc_id', $unitCurricularIds)  // Filtra pelas unidades curriculares
                        ->join('students', 'uc_to_students.student_num', '=', 'students.id')  // Faz o join com os alunos
                        ->select('students.*')
                        ->get();

        // Retorna a view com os alunos encontrados
        return view('users.responsible.students', compact('students'));
    }




    public function listNotifications()
    {
        // Obtém o ID do responsável autenticado
        $ucResponsiblesId = Auth::id();
    
        // Busca todas as notificações associadas ao responsável
        $notifications = Notification::where('uc_responsible_id', $ucResponsiblesId)->get();
    
        // Busca os responsáveis pela UC associados ao responsável autenticado
        $ucResponsibles = UcResponsible::with(['users', 'ucs.course.institution'])
            ->where('id', $ucResponsiblesId)
            ->get();
    
            $students = Student::with(['users', 'ucs.course.institution'])
            ->whereHas('ucs', function ($query) use ($ucResponsiblesId) {
                $query->whereHas('uc_to_students', function ($query2) use ($ucResponsiblesId) {
                    // Verifique a coluna correta de relacionamento
                    $query2->where('uc_responsible_id', $ucResponsiblesId);
                });
            })
            ->get();
        
    
        // Retorna a view com as notificações, responsáveis e alunos
        return view('users.responsible.notifications', compact('notifications', 'ucResponsibles', 'students'));
    }
    
    

}