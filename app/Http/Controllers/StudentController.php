<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student; 
use App\Models\User; 
use App\Models\Notification; 
use App\Models\AttendanceRecord; 
use App\Models\InternshipOffer;
use App\Models\UcToStudent; 
use App\Models\UnitCurricular;
use App\Models\FinalReport;
use App\Http\Resources\AttendanceRecordResource;
use App\Http\Resources\InternshipOfferResource;
use App\Http\Resources\FinalReportResource; 
use App\Http\Resources\StudentResource; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->profile !== 'Student') {
            return redirect()->back()->with('error', 'Você não tem permissão para eceder esta página.');
        }

        $user = Auth::user();

        // Obtem o student associado ao user logado
        $student = $user->student; 
    
        // Obtem o assigned_internship_id do student
        $assignedInternshipId = $student->assigned_internship_id;

        // Obtem as notifications do student
        $notifications = Notification::where('student_num', $user->id)->get();

        // Filtra os registros de presenca com base no internship_offer_id
        $attendanceRecords = AttendanceRecord::where('internship_offer_id', $assignedInternshipId)->get();

        $attendanceRecords = AttendanceRecordResource::collection($attendanceRecords)->resolve();

        return view('users.student.dashboard', compact('user','notifications', 'attendanceRecords'));
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
            'phone' => 'required|string|max:9|unique:students,phone'. ($student ? ',' . $student->id : ''),
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'phone.required' => 'O campo telefone é obrigatório',
            'phone.max' => 'O telefone não pode ter mais de 9 valores',
            'phone.unique' => 'O telefone já está em uso',
            'picture.image' => 'O arquivo deve ser uma imagem',
            'picture.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif, svg',
            'picture.max' => 'A imagem não pode ter mais de 2048 KB',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $validator->validated();
        
        if ($student) {
            // Atualiza o registro existente
            $student->update($data);

            // Verifica se a imagem foi enviada e faz o upload
            if ($request->hasFile('picture')) {
                if ($student->picture && Storage::exists($student->picture)) {
                    Storage::delete($student->picture);
                }
                $path = $request->file('picture')->store('images/uploads', 'public');
                $student->update(['picture' => $path]);
            }

            return redirect()->route('student.profile')->with('success', 'Perfil atualizado com sucesso!');
        } else {
            // Cria um novo registro
            $student = Student::create($data);

            // Associa o student ao user logado
            $user->id_student = $student->id;
            $user->save();

            if ($request->hasFile('picture')) {
                $path = $request->file('picture')->store('images/uploads', 'public');
                $student->update(['picture' => $path]);
            }

            return redirect()->route('student.profile')->with('success', 'Perfil criado com sucesso!');
        }

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
    
        // Se a validacao falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Dados validados
        $validated = $validator->validated();
    
        // Prepara os dados para atualização
        $dataToUpdate = [
            'phone' => $validated['phone'],
        ];
    
        // Verifica se a foto foi enviada e processa o upload
        if ($request->hasFile('picture')) {
            // Remove a foto antiga se existir
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

    // Metodo para ler notificacao
    public function readNotification(Request $request, $id)
    {
        // Encontra a notificacao pelo ID
        $notification = Notification::find($id);
    
        // Atualize o status da notificação para lida
        $notification->status_visualization = 1; 

        // Guarda
        $notification->save(); 
    
        return redirect()->route('student.dashboard')->with('success', 'Notificação marcada como lida');
    }
    
    // Metodo para registar todos os registos diarios
    public function storeAttendance(Request $request) 
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'morning_start_time' => 'required|date_format:H:i', 
            'morning_end_time' => 'required|date_format:H:i|after:morning_start_time', 
            'afternoon_start_time' => 'required|date_format:H:i',
            'afternoon_end_time' => 'required|date_format:H:i|after:afternoon_start_time', 
            'summary' => 'required|string|max:1000',
        ], [
            'morning_start_time.date_format' => 'O horário de início da manhã não está no formato correto',
            'morning_end_time.after' => 'O horário de fim da manhã deve ser depois do início',
            'afternoon_start_time.date_format' => 'O horário de início da tarde não está no formato correto',
            'afternoon_end_time.after' => 'O horário de fim da tarde deve ser depois do início',
        ]);
        
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Obtem os dados validados
        $data = $validator->validated();
    
        // Calcula o tempo total de aprovação em segundos
        $morningHours = strtotime($data['morning_end_time']) - strtotime($data['morning_start_time']);
        $afternoonHours = strtotime($data['afternoon_end_time']) - strtotime($data['afternoon_start_time']);
        $totalSeconds = $morningHours + $afternoonHours;
        
        // Converte o tempo total para o formato HH:MM
        $formattedApprovalTime = gmdate('H:i', $totalSeconds);
    
        $data['approval_hours'] = $formattedApprovalTime; 
        $data['approval_status'] = 'pending'; 
    
        // Obtem o user logado
        $user = Auth::user(); 

        $student = $user->student; 
    
        $data['internship_offer_id'] = $student->assigned_internship_id; 
        
        if ($data['internship_offer_id'] === null) {
            return redirect()->route('student.dashboard')->with('info', 'Ainda não tens estagio atribuido');
        }

        $data['date'] = now()->format('Y-m-d'); 
    
        // Cria um novo registro de presença
        $attendanceRecord = AttendanceRecord::create($data);
    
        // Verifica se o registro foi criado com sucesso
        if ($attendanceRecord) {
            return redirect()->route('student.dashboard')->with('success', 'Registro de presença criado com sucesso!');
        } else {
            return redirect()->route('student.dashboard')->with('error', 'Erro ao criar registro de presença.');
        }
    }

    //  Metodo para fazer download de todos os registos em PDF
    public function download()
    {    
        // Obtem todos os registros de presenca do aluno logado
        $user = Auth::user();

        // Obtem o student associado ao user logado
        $student = $user->student; 
        
        $studentName = $user ? $user->name : 'Nome não encontrado';

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
    
        // Nome do arquivo para download
        $fileName = 'Registos_Diários_' . $student->name . '.pdf';
    
        // Retorna o PDF para download
        return $dompdf->stream($fileName, ['Attachment' => true]);
    }

    // Metodo listar todas as ofertas de estagio
    public function listInternships(){

        // Obtem o user logado
        $user = Auth::user(); 

        $student = $user->student; 

        // Procura as UCs do student
        $ucIds = UcToStudent::where('student_num', $student->id)->pluck('uc_id');

        // Obter os course_ids das UCs
        $courseIds = UnitCurricular::whereIn('id', $ucIds)->pluck('course_id')->unique();

        // Mostra so ofertas de estagio que pertencem ao mesmo curso e ofertas que tenham um plano aprovado
        $internships = InternshipOffer::whereIn('course_id', $courseIds)
        ->whereHas('plans', function($query) {
            $query->where('status', 'approved');
        })
        ->get();

        $internships = InternshipOfferResource::collection($internships)->resolve();

        return view('users.student.internships', compact('internships'));
    }

    // Metodo para uma aluno candidatar-se a uma oferta de estagio
    public function applyInternships(Request $request, $id){

        // Obtem o user logado
        $user = Auth::user(); 

        $student = $user->student; 

        $internshipOffer = InternshipOffer::find($id);

        // Verifica se o aluno já tem uma oferta pendente
        if (!is_null($student->pending_internship_offer_id)) {
            return redirect()->route('student.internships')->withErrors('Você já tem uma candidatura pendente. Não é possível candidatar-se a mais de uma oferta');
        }

        // Verifica se o aluno já está associado a uma oferta de estágio
        if (!is_null($student->assigned_internship_id)) {
            return redirect()->route('student.internships')->withErrors('Você já está associado a uma oferta de estágio');
        }

        // Verifica se a oferta de estágio está fechada
        if ($internshipOffer->status === 'closed') {
            return redirect()->route('student.internships')->withErrors('A oferta de estágio está fechada. Não é possível candidatar-se');
        }

        // Atualiza o status da oferta para fechado
        $internshipOffer->status = 'closed';
        $internshipOffer->save(); 

        // Atualiza o campo pending_internship_offer_id do aluno
        $student->pending_internship_offer_id = $internshipOffer->id;
        $student->save(); 
        

        return redirect()->route('student.internships')->with('success', 'Candidatura realizada com sucesso. Aguarde a aprovação');
    }

    // Metodo para uma aluno remover candidatura a um estagio
    public function removeInternships(Request $request, $id){

        // Obtem o student logado
        $user = Auth::user(); 

        $student = $user->student; 

        $internshipOffer = InternshipOffer::find($id);

         // Verifica se a oferta de estagio existe
        if (!$internshipOffer) {
            return redirect()->route('student.internships')->withErrors('Oferta de estágio não encontrada');
        }

        // Verifica se o aluno tem uma candidatura pendente para esta oferta
        if ($student->pending_internship_offer_id !== $internshipOffer->id) {
            return redirect()->route('student.internships')->withErrors('Você não pode remover esta candidatura, pois não é sua');
        }

        // Atualiza o status da oferta para aberto
        $internshipOffer->status = 'open';
        $internshipOffer->save(); 

        $student->pending_internship_offer_id = null;
        $student->save(); 
        
        return redirect()->route('student.internships')->with('success', 'Candidatura removida com sucesso');
    }

    // Metodo para mostrar os relatorios finais
    public function listReports(){
    
        // Obtem o user logado
        $user = Auth::user(); 

        $student = $user->student; 

        // Procura os relatorio finais que tem o internship_offer_id igual ao assigned_internship_id do studen logado
        $final_reports = FinalReport::where('internship_offer_id', $student->assigned_internship_id)->get();

        $final_reports = FinalReportResource::collection($final_reports)->resolve();

        return view('users.student.reports', compact('final_reports'));
    }

    // Metodo para registar relatorio final
    public function storeReports(Request $request)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'final_report_file' => 'required|file|mimes:pdf|max:5000',
        ], [
            'final_report_file.required' => 'O ficheiro do relatório final é obrigatório',
            'final_report_file.file' => 'O ficheiro deve ser um ficheiro válido',
            'final_report_file.mimes' => 'O ficheiro deve ser um PDF',
            'final_report_file.max' => 'O ficheiro é muito grande',
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $validator->validated();
    
        // Obtem o student logado
        $user = Auth::user(); 
        
        $student = $user->student; 
    
        // Obter o assigned_internship_id do estudante
        $assignedInternshipId = $student->assigned_internship_id;
    
        // Verifica se já existe um relatório final para o internship_offer_id do estudante
        $existingReport = FinalReport::where('internship_offer_id', $assignedInternshipId)->first();
    
        if ($existingReport) {
            return redirect()->back()->withErrors([
                'final_report' => 'Você já submeteu um relatório final para esta oferta de estágio.'
            ])->withInput();
        }
    
        // Calcular o total de horas aprovadas dos registos diários apenas com status Aprovado
        $internshipOffer = InternshipOffer::find($assignedInternshipId);
        $totalApprovedHours = $internshipOffer->attendanceRecords()->where('approval_status', 'approved')->sum('approval_hours'); 
    
        $data['total_hours'] = $totalApprovedHours; 
    
        // Conta os dias
        $totalDays = $internshipOffer->attendanceRecords()->where('approval_status', 'approved')->distinct('date')->count('date'); 
        $data['total_days'] = $totalDays; 
    
        // Recupera o total de horas registadas a partir do plano
        $totalHoursFromPlan = $internshipOffer->plans()->sum('total_hours'); 
        
         // Recupera o total de horas registadas a partir do último plano aprovado
        $lastApprovedPlan = $internshipOffer->plans()->where('status', 'approved')->orderBy('created_at', 'desc')->first();
        
        // Verifica se existe um plano aprovado
        if ($lastApprovedPlan) {
            $totalHoursFromPlan = $lastApprovedPlan->total_hours; 
        } else {
            return redirect()->back()->withErrors([
                'total_hours' => 'Nenhum plano aprovado encontrado para esta oferta de estágio.'
            ])->withInput();
        }

        // Verifica se as total_hours registadas são iguais ou superiores às horas exigidas no plano
        if ($totalApprovedHours <= floatval($totalHoursFromPlan)) {
            return redirect()->back()->withErrors([
                'total_hours' => 'As horas registadas (' . $totalApprovedHours . ' horas) não correspondem às horas definidas no plano da oferta de estágio (' . $totalHoursFromPlan . ' horas).'
            ])->withInput();
        }
    
        // Upload do pdf do relatório final
        if ($request->hasFile('final_report_file')) {

            $internshipOfferId = $assignedInternshipId; 

            $internshipOffer = InternshipOffer::findOrFail($internshipOfferId);
            
            $title = $internshipOffer->title;
    
            $fileName = 'Relatorio_Final_' . str_replace(' ', '_', $title) . '.' . $request->file('final_report_file')->getClientOriginalExtension();
            
            $path = $request->file('final_report_file')->storeAs('final_reports', $fileName, 'public'); 
            $data['final_report_file_path'] = $path; 
        }   
    
        // Cria o novo relatório final
        $final_report = FinalReport::create(array_merge($data, ['internship_offer_id' => $assignedInternshipId]));
    
        if ($final_report) {
            // Retorna para a página de relatórios finais com uma mensagem de sucesso
            return redirect()->route('student.reports')->with('success', 'Relatório final submetido com sucesso!');
        } else {
            // Retorna para a página de relatórios finais com uma mensagem de erro
            return redirect()->route('student.reports')->with('error', 'Erro ao submeter relatório final');
        }
    }
}