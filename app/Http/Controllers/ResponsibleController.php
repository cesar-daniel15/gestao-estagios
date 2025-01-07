<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UnitCurricular;
use App\Models\UcResponsible;
use App\Models\UcToStudent;
use App\Models\UcToResponsible; 
use App\Models\User;
use App\Models\Notification;
use App\Models\Student;
use App\Models\InternshipOffer;
use App\Models\Company;
use App\Models\Institution;
use App\Models\Course;
use App\Models\FinalReport;
use App\Models\InternshipPlan;
use App\Models\AttendanceRecord;
use Illuminate\Support\Str; 
use App\Http\Resources\UcResponsibleResource; 
use App\Http\Resources\StudentResource; 
use App\Http\Resources\NotificationResource;
use App\Http\Resources\InternshipOfferResource;
use App\Http\Resources\AttendanceRecordResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

class ResponsibleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->profile !== 'Responsible') {
            return redirect()->back()->with('error', 'Você não tem permissão para acessar esta página.');
        }
    
        $user = Auth::user();
        $responsible = $user->responsible;
    
        // Obtem as unidades curriculares associadas ao responsavel
        $unitCurricularIds = UcToResponsible::where('uc_responsible_id', $responsible->id)->pluck('uc_id');
    
        // Obtem os cursos associados às unidades curriculares
        $courseIds = UnitCurricular::whereIn('id', $unitCurricularIds)->pluck('course_id');
    
        // Conta os alunos com estágio
        $studentsCurrentlyInterning = Student::whereNotNull('assigned_internship_id')
            ->whereHas('ucs', function ($query) use ($unitCurricularIds, $courseIds) {
                $query->whereIn('uc_id', $unitCurricularIds)
                    ->whereIn('course_id', $courseIds);
            })->count();
    
        // Conta alunos sem estágio 
        $studentsWithoutInternship = Student::whereNull('assigned_internship_id') 
            ->whereHas('ucs', function ($query) use ($unitCurricularIds, $courseIds) {
                $query->whereIn('uc_id', $unitCurricularIds)
                    ->whereIn('course_id', $courseIds);
            })->count();
    
        // Obtem estagios disponiveis
        $internshipsAvailable = InternshipOffer::where('status', 'open')
            ->whereIn('course_id', $courseIds)
            ->count();
    
        return view('users.responsible.dashboard', compact('user', 'studentsCurrentlyInterning', 'studentsWithoutInternship', 'internshipsAvailable'));
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

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('images/uploads', 'public');
            $responsible->update(['picture' => $path]);
        }

        // Associa o responsável ao utilizador logado
        $user->id_responsible = $responsible->id;
        $user->save();

        return redirect()->route('responsible.profile')->with('success', 'Perfil criado com sucesso!');
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

    // Se a validacao falhar
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Dados validados
    $validated = $validator->validated();

    // Prepara os dados para atualizacao
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
    
    public function listStudents()
    {
        // Obtem o user logado
        $user = Auth::user();
        
        // Obtem o responsável associado ao user
        $responsible = $user->responsible; 
    
        // Procura unidades curriculares associadas ao responsável
        $unitCurricularIds = UcToResponsible::where('uc_responsible_id', $responsible->id)->pluck('uc_id');
    
        // Obtem os cursos associados às unidades curriculares
        $courseIds = UnitCurricular::whereIn('id', $unitCurricularIds)->pluck('course_id'); 
    
        // Obtem os alunos associados a essas unidades curriculares e que pertencem ao mesmo curso
        $students = Student::whereHas('ucs', function ($query) use ($unitCurricularIds, $courseIds) {
            $query->whereIn('uc_id', $unitCurricularIds)->whereIn('course_id', $courseIds);
        })->with('users')->get();
        
        $students = StudentResource::collection($students)->resolve();
        
        $unitCurriculars = UnitCurricular::all();

        return view('users.responsible.students', compact('students','unitCurriculars'));
    }

    // Metodo para registar um student
    public function storeStudent(Request $request)
    {
        // Validação dos dados 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', 
            'phone' => 'required|string|max:15', 
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'lective_year' => 'required|string',
        ], [
            'lective_year.required' => 'O campo ano letivo é obrigatório',
        ]);
    
        // Obtem o user autenticado
        $user = Auth::user();
        $responsibleId = $user->responsible->id; 
    
        // Verificar se o responsável tem uma unidade curricular associada
        $responsibleUnit = DB::table('uc_to_responsibles')
            ->where('uc_responsible_id', $responsibleId)
            ->first();
    
        if (!$responsibleUnit) {
            return redirect()->back()->withErrors(['uc_id' => 'Nenhuma unidade curricular associada ao responsável.'])->withInput();
        }
    
        // Criar do user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'profile' => 'student', 
            'account_is_verified' => 1, 
            'id_student' => null, 
        ]);
    
        // Criar do aluno
        $student = Student::create([
            'id' => $user->id, 
            'phone' => $request->phone,
            'picture' => $request->file('picture') ? $request->file('picture')->store('pictures') : null, 
        ]);
    
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('images/uploads', 'public');
            $student->update(['picture' => $path]); // Atualiza o caminho da foto na bd
        }
    
        // Atualiza o user para incluir o id_student
        $user->id_student = $student->id; // Atribui o id do aluno ao campo id_student do user
        $user->save();
    
        // Associar o aluno a tabela uc_to_students
        DB::table('uc_to_students')->insert([
            'student_num' => $student->id, 
            'uc_id' => $responsibleUnit->uc_id, 
            'lective_year' => $request->lective_year, 
        ]);
    
        return redirect()->route('responsible.students')->with('success', 'Aluno registrado com sucesso');
    }

    // Metodo para dar update a um student
    public function updateStudent(Request $request, Student $student)
    {
        // Validação dos dados 
        $validator = Validator::make($request->all(), [
            'phone' => 'string|max:9|unique:students,phone,' . $student->id, 
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'phone.string' => 'O telefone deve ser uma string',
            'phone.max' => 'O telefone não pode ter mais de 9 valores',
            'phone.unique' => 'O telefone do responsável já está em uso',
            'picture.image' => 'O arquivo deve ser uma imagem',
            'picture.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif, svg',
            'picture.max' => 'A imagem não pode ter mais de 2048 KB',
            'assigned_internship_id.exists' => 'O estágio atribuído não existe',
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $validator->validated();
    
        // Verifica se há uma foto do student 
        if ($request->hasFile('picture')) {
            // Apaga a foto antiga
            if ($student->picture && Storage::disk('public')->exists($student->picture)) {
                Storage::disk('public')->delete($student->picture);
            }
    
            // Armazena a nova foto
            $path = $request->file('picture')->store('images/uploads', 'public');
            $data['picture'] = $path; // Atualiza o caminho da foto
        }
    
        // Faz a atualização dos dados do student
        $update = $student->update($data);
    
        // Verifica se a atualização ocorreu com sucesso
        if ($update) {
            return redirect()->route('responsible.students')->with('success', 'Aluno atualizado com sucesso!');
        } else {
            return redirect()->route('responsible.students')->with('error', 'Erro ao atualizar o aluno');
        }
    }

    // Metodo para apagar um student
    public function destroyStudent(Student $student){

        $deleted = $student->delete();   

        // Verificar se foi apagada
        if($deleted){
            return redirect()->route('responsible.students')->with('success', 'Aluno excluído com sucesso!');

        }else
        {
            return redirect()->route('responsible.students')->with('error', 'Erro ao excluir o aluno');
        }
    }

    // Listar todas as ofertas de estágio de alunos da instituição
    public function listInternships() {

        // User logado
        $user = Auth::user();

        // Obter as ofertas de estágio com os relacionamentos necessários
        $internship_offers = InternshipOffer::with(['company', 'institution', 'course', 'plans', 'student.users'])->get();

        // Obter todas as empresas
        $companies = Company::all();

        $students = Student::all();
    
        // Obter todas as instituições
        $institutions = Institution::all();
    
        // Obter todos os cursos
        $courses = Course::all();
    
        $finalReports = FinalReport::all();

        $studentsByInternshipOffer = [];

        // Corrigir a referência à view para corresponder ao arquivo correto
        return view('users.responsible.internship', [
            'internship_offers' => InternshipOfferResource::collection($internship_offers)->resolve() ?? [], 
            'companies' => $companies, 
            'institutions' => $institutions,
            'students' => StudentResource::collection($students)->resolve() ?? [],
            'courses' => $courses, 
            'finalReports' => $finalReports,
        ]);
    }

    // Metodo para concorda com plano e oferta de estagio
    public function agreeInternships(Request $request, $id)
    {
        // Tenta encontrar o plano de estagio com o ID fornecido
        $internship_plan = InternshipPlan::find($id);
            
        // Verifica se o plano existe
        if (!$internship_plan) {
            return redirect()->back()->withErrors(['id' => 'Plano de estágio não encontrado.'])->withInput();
        }
    
        // Valida se o campo 'approved_by_uc' foi enviado corretamente
        $validator = Validator::make($request->all(), [
            'approved_by_uc' => 'required|in:0,1',  
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Atualiza o campo 'approved_by_uc' com o valor enviado
        $internship_plan->approved_by_uc = $request->input('approved_by_uc');

        if ($request->input('approved_by_uc') == 1) {
            $internship_plan->status = 'approved'; 
        } else {
            $internship_plan->status = 'rejected';  
        }

        $internship_plan->save();
    
        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->route('responsible.internships') ->with('success', 'Status da oferta mudado com sucesso');
    }

    public function associateInternships(Request $request, $id)
    {
        // Validação do request
        $request->validate([
            'student_id' => 'required|exists:students,id', 
        ]);
    
        // Encontrar o aluno que está se candidatando
        $student = Student::findOrFail($request->student_id);

        if ($student->assigned_internship_id) {
            return redirect()->back()->withErrors(['error' => 'O aluno já está associado a uma oferta de estágio']);
        }

        // Verificar se o aluno tem uma oferta pendente
        if ($student->pending_internship_offer_id == $id) {
            // Atualizar o ID da oferta de estágio atribuída
            $student->assigned_internship_id = $id;
            $student->pending_internship_offer_id = null; // Limpar o ID da oferta pendente
            $student->save();
    
            return redirect()->route('responsible.internships')->with('success', 'Estágio atribuído com sucesso!');
        }
    
        return redirect()->back()->withErrors(['error' => 'O aluno não está associado a esta oferta de estágio.']);
    }

    // Metodo para listar todos os ficheiros disponiveis para exportar
    public function listExportFiles()
    {
        // Obtem o user logado
        $user = Auth::user();
            
        // Obtem o responsável associado ao user
        $responsible = $user->responsible; 
    
        // Procura unidades curriculares associadas ao responsável
        $unitCurricularIds = UcToResponsible::where('uc_responsible_id', $responsible->id)->pluck('uc_id');
    
        // Obtem os cursos associados às unidades curriculares
        $courseIds = UnitCurricular::whereIn('id', $unitCurricularIds)->pluck('course_id'); 
    
        // Obtem os alunos associados a essas unidades curriculares e que pertencem ao mesmo curso
        $students = Student::with('internshipOffer.finalReports') 
        ->whereHas('ucs', function ($query) use ($unitCurricularIds, $courseIds) {
            $query->whereIn('uc_id', $unitCurricularIds)
                ->whereIn('course_id', $courseIds);
        })
        ->whereNotNull('assigned_internship_id') 
        ->with('users')
        ->get();
        
        // Obtem os IDs dos alunos
        $studentIds = $students->pluck('id');
    
        // Obtem os registros de presenca dos alunos
        $attendanceRecords = AttendanceRecord::whereIn('internship_offer_id', function ($query) use ($studentIds) {
            $query->select('assigned_internship_id')
                ->from('students')
                ->whereIn('id', $studentIds);
        })->get();    

        // Obtem os relatorio finais dos alunos
        $finalReports = FinalReport::whereIn('internship_offer_id', function ($query) use ($studentIds) {
            $query->select('internship_offer_id')
                ->from('students')
                ->whereIn('id', $studentIds);
        })->get();   
        
        return view('users.responsible.exports', [
            'students' => StudentResource::collection($students)->resolve() ?? [],
            'attendanceRecords' => $attendanceRecords,
            'finalReports' => $finalReports,
        ]);
    }

    public function downloadExportFilesIntership($studentId)
    {
        // Obtem o user logado
        $user = Auth::user();
    
        // Obtem o responsável associado ao user logado
        $responsible = $user->responsible;
    
        // Obtem o aluno associado ao responsável
        $student = Student::with('internshipOffer.finalReports') 
        ->where('id', $studentId)
        ->whereHas('ucs', function ($query) use ($responsible) {
                $unitCurricularIds = UcToResponsible::where('uc_responsible_id', $responsible->id)->pluck('uc_id');
                $query->whereIn('uc_id', $unitCurricularIds);
            })
            ->firstOrFail(); 

        $studentName = $student->users->first()->name ?? 'Nome não encontrado';
    
        // Obtem o assigned_internship_id do student
        $assignedInternshipId = $student->assigned_internship_id;
    
        // Filtra os registros de presenca aprovados com base no internship_offer_id 
        $attendanceRecords = AttendanceRecord::where('internship_offer_id', $assignedInternshipId)
            ->where('approval_status', 'approved') 
            ->get();
    
        $attendanceRecords = AttendanceRecordResource::collection($attendanceRecords)->resolve();  
    
        $internshipOffer = InternshipOffer::find($assignedInternshipId);
    
        // Configuracoes do Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);
    
        // Renderiza para a view
        $html = view('pdf.attendanceRecord', [
            'attendanceRecords' => $attendanceRecords,
            'studentName' => $studentName,
            'internshipOffer' => $internshipOffer
        ])->render();
    
        // Carrega o HTML no Dompdf
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // Nome do ficheiro para download
        $fileName = 'Registos_Diários_' . $student['name'] . '.pdf';

        // Retorna o PDF para download
        return $dompdf->stream($fileName, ['Attachment' => true]);
    }

    public function downloadExportFilesFinal($studentId, $finalReportId = null)
    {
        if ($finalReportId === null) {
            return redirect()->back()->with('info', 'Relatório final não está disponível');
        }

        $finalReport = FinalReport::findOrFail($finalReportId);
    
        // Verifica se o ficheiro existe
        if (Storage::disk('public')->exists($finalReport->final_report_file_path)) {
            return Storage::disk('public')->download($finalReport->final_report_file_path);
        }
    }

    public function listNotifications()
    {
        // Obtem o usuário autenticado
        $user = Auth::user(); 
    
        // Obtem o responsável associado ao usuário
        $responsible = $user->responsible;
        
        // Verifica se o responsável existe
        if (!$responsible) {
            return redirect()->back()->with('error', 'Nenhum responsável encontrado para este usuário.');
        }
    
        // Procura todas as notificações associadas ao responsável
        $notifications = Notification::where('uc_responsible_id', $responsible->id)->get();
    
        $notifications = NotificationResource::collection($notifications)->resolve();
    
        // Procura os responsáveis pela UC associados ao responsável autenticado
        $ucResponsibles = UcResponsible::with(['users', 'ucs.course.institution']) 
            ->where('id', $responsible->id) 
            ->get();
    
        // Obtem os course_ids das unidades curriculares associadas ao responsável
        $courseIds = UcResponsible::where('id', $responsible->id)->with('ucs.course') ->get()->pluck('ucs.*.course.id')->flatten()->unique();
    
        // Procura os alunos relacionados ao mesmo curso
        $students = Student::whereHas('ucs.course', function ($query) use ($courseIds) {
            $query->whereIn('id', $courseIds);
        })->get();
    
        // Retorna a view com as notificações, responsáveis, alunos e o usuário
        return view('users.responsible.notifications', compact('notifications', 'ucResponsibles', 'students', 'user'));
    }
    // Metodo para criar notficacoes
    public function storeNotifications(Request $request)
    {
         // Obtem o user logado
        $user = Auth::user(); 

        $responsible = $user->responsible; 
        
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'student_num' => 'required|exists:students,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'status_visualization' => 'nullable|boolean',
        ], [
            'student_num.exists' => 'O estudante não existe.',
            'title.required' => 'O título da notificação é obrigatório.',
            'content.required' => 'O conteúdo da notificação é obrigatório.',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        
        // Adiciona o ID do responsável à data da notificação
        $data['uc_responsible_id'] = $responsible->id;

        // Criação da nova notificação
        $notification = Notification::create($data);

        if ($notification) {
            // Retorna à página de notificações com uma mensagem de sucesso
            return redirect()->route('responsible.notifications')->with('success', 'Notificação criada com sucesso!');
        } else {
            // Retorna à página de notificações com uma mensagem de erro
            return redirect()->route('responsible.notifications')->with('error', 'Erro ao criar notificação.');
        }
    }
}