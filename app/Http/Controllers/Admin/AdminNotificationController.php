<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\UcResponsible;  // Importando o modelo UcResponsible
use App\Models\Student;
use Illuminate\Support\Str; 
use App\Http\Resources\NotificationResource;
use App\Http\Resources\UcResponsibleResource;  // Importando o recurso UcResponsibleResource
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;


class AdminNotificationController extends Controller
{ 
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenha as notificações
        $notification = Notification::all();
        
        // Outras variáveis
        $ucResponsibles = UcResponsible::all();
        $students = Student::all();
    
        return view('admin.notifications', [
            'notification' => NotificationResource::collection($notification)->resolve() ?? [],
            'ucResponsibles'=> UcResponsibleResource::collection($ucResponsibles)->resolve() ?? [],
            'students'=> StudentResource::collection($students)->resolve() ?? []
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
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'uc_responsible_id' => 'required|exists:uc_responsibles,id',
            'student_num' => 'required|exists:students,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'status_visualization' => 'nullable|boolean',
        ], [
            'uc_responsible_id.exists' => 'O responsável pela UC não existe.',
            'student_num.exists' => 'O estudante não existe.',
            'title.required' => 'O título da notificação é obrigatório.',
            'content.required' => 'O conteúdo da notificação é obrigatório.',
        ]);
        
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $data = $validator->validated();

        // Criação da nova notificação
        $notification = Notification::create($data);
    
        if ($notification) {
            // Retorna à página de notificações com uma mensagem de sucesso
            return redirect()->route('admin.notifications.index')->with('success', 'Notificação criada com sucesso!');
        } else {
            // Retorna à página de notificações com uma mensagem de erro
            return redirect()->route('admin.notifications.index')->with('error', 'Erro ao criar notificação.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {

        // Return para a view com os dados
        return view('admin.notifications.index', compact('notification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'uc_responsible_id' => 'nullable|exists:uc_responsibles,id',
            'student_num' => 'nullable|exists:students,id',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string|max:2000',
            'status_visualization' => 'nullable|boolean',
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
        $data = $validator->validated();

        // Realiza a atualização da notificação
        $update = $notification->update($data);

        // Verifica se a atualização foi bem-sucedida
        if ($update) {
            return redirect()->route('admin.notifications.index')->with('success', 'Notificação atualizada com sucesso!');
        } else {
            return redirect()->route('admin.notifications.index')->with('error', 'Erro ao atualizar a notificação.');
        }
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(Notification $notification)
    {
        // Remove uma instituicao da db     

        $deleted = $notification->delete();

        // Verificar se foi apagada
        if($deleted){
            return redirect()->route('admin.notifications.index')->with('success', 'Instituição excluída com sucesso!');

        }else
        {
            return redirect()->route('admin.notifications.index')->with('error', 'Erro ao excluir a instituição');
        }
    }
}
        
    