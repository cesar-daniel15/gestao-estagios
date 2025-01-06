<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use App\Models\InternshipOffer;
use App\Models\Company;
use App\Models\Institution;
use App\Models\Student;
use App\Models\Course;
use App\Models\InternshipPlan;
use App\Models\AttendanceRecord;
use App\Models\FinalReport; 
use App\Http\Resources\InternshipOfferResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\InstitutionResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\InternshipPlanResource;
use App\Http\Resources\AttendanceRecordResource;
use App\Http\Resources\FinalReportResource; 
use Carbon\Carbon;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->profile !== 'Company') {
            return redirect()->back()->with('error', 'Você não tem permissão para aceder a esta página.');
        }
    
        $user = Auth::user();
        $companyId = $user->company->id;
        
        // Alunos atualmente a estagiar 
        $studentsCurrentlyInterning = Student::whereHas('internshipOffer', function($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->count();
    
        // Total de planos aceites
        $acceptedPlans = InternshipPlan::whereHas('internshipOffer', function($query) use ($companyId) {
            $query->where('company_id', $companyId)
                    ->where('approved_by_uc', '1');
        })->count();
    
        // Total de Estágios Pendentes / Rejeitados
        $pendingPlans = InternshipPlan::whereHas('internshipOffer', function($query) use ($companyId) {
            $query->where('company_id', $companyId)
                    ->where('approved_by_uc', '0');
        })->count();
    
        return view('users.company.dashboard', compact('user', 'studentsCurrentlyInterning', 'acceptedPlans', 'pendingPlans'));
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
        $company = $user->company; 

        // Validação
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:9|unique:companies,phone' . ($company ? ',' . $company->id : ''),
            'industry' => 'required|string|max:255',
            'brief_description' => 'nullable|max:255',
            'foundation_date' => 'required|date|max:255',
            'address' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'phone.required' => 'O campo telefone é obrigatório',
            'phone.unique' => 'O telefone da empresa já está em uso',
            'phone.max' => 'O campo telefone só pode ter 9 valores',
            'industry.required' => 'O campo indústria é obrigatório',
            'brief_description.max' => 'A descrição breve não pode ter mais de 255 caracteres',
            'foundation_date.required' => 'A data de fundação é obrigatória',
            'foundation_date.date' => 'A data de fundação deve ser uma data válida',
            'address.required' => 'O campo morada é obrigatório',
            'logo.image' => 'O arquivo deve ser uma imagem',
            'logo.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif, svg',
            'logo.max' => 'A imagem não pode ter mais de 2048 KB',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $validator->validated();
    
        if ($company) {
            // Se a empresa ja existir faz update 
            $company->update($data);
    
            // Verifica se o logo foi enviado e faz o upload
            if ($request->hasFile('logo')) {
                // Apaga o logo antigo
                if ($company->logo && Storage::exists($company->logo)) {
                    Storage::delete($company->logo);
                }
                $path = $request->file('logo')->store('images/uploads', 'public');
                $company->update(['logo' => $path]);
            }
    
            return redirect()->route('company.profile')->with('success', 'Perfil atualizado com sucesso!');
        } else {
            // Cria uma nova instituicao
            $company = company::create($data);
    
            // Associar a instituicao ao user logado
            $user->id_company = $company->id;
            $user->save();
    
            // Verifica se o logo foi enviado e faz o upload
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('images/uploads', 'public');
                $company->update(['logo' => $path]);
            }
    
            return redirect()->route('company.profile')->with('success', 'Perfil concluído com sucesso!');
        }
    
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $company = $user->company ?? null;

        return view('users.company.profile', compact('user', 'company'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Listar todas as ofertas de estágio
    public function listInternships(){
        // User logado
        $user = Auth::user();

        // Empresa associada ao user
        $company = $user->company;

        // Obtem as ofertas de estágio com os relacionamentos necessários
        $internship_offers = InternshipOffer::with(['company', 'institution', 'course', 'plans'])->where('company_id', $company->id)->get();            
        
        // Obtem todas as empresas
        $companies = Company::all();

        // Obtem todas as instituições
        $institutions = Institution::all();

        // Obtem todos os cursos
        $courses = Course::all();

        // Obtem todos os planos
        $internship_plans = InternshipPlan::all(); 

        $finalReports = FinalReport::all();

        return view('users.company.internships', [
            'internship_offers' => InternshipOfferResource::collection($internship_offers)->resolve() ?? [],
            'companies' => $companies, 
            'institutions' => $institutions, 
            'courses' => $courses, 
            'internship_plans' => $internship_plans, 
            'finalReports' => $finalReports, 
        ]);
                
    }

    // Criar Oferta de Estágio
    public function storeInternships(Request $request) {

        // User logado
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'institution_id' => 'required|exists:institutions,id',
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'nullable|date',
            'final_report_id' => 'nullable|exists:final_reports,id',
        ]);

       // Se a valicao falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Adiciona o company_id do user logado
        $data['company_id'] = $user->company->id;

        // Atribui o defautl status
        $data['status'] = 'open';

        // Cria a nova oferta de estágio
        $internship_offer = InternshipOffer::create($data);

        if ($internship_offer) {
            return redirect()->route('company.internships')->with('success', 'Oferta de estágio criada com sucesso!');
        } else {
            return redirect()->route('company.internships')->with('error', 'Erro ao criar a oferta de estágio.');
        }
    }

    // Metodo para fechar ofertas de estagio que ja passaram do prazo
    public function closeOffer()
    {
        // Data de hoje
        $today = Carbon::now()->toDateString(); 

        // Encontra todas as ofertas abertas cuja data limite ja passou
        $offers = InternshipOffer::where('status', 'open')->where('deadline', '<', $today)->get();
        
        if ($offers->isEmpty()) {
            return redirect()->route('company.internships');
        }

        // Contador para ofertas fechadas
        $closedCount = 0;

        foreach ($offers as $offer) {
            $offer->status = 'closed'; 
            $offer->save(); 
            $closedCount++; 
        }

        // Verifica se alguma oferta foi fechada
        if ($closedCount > 0) {
            return redirect()->route('company.internships')->with('info', 'Algumas ofertas foram fechadas');
        } else {
            return redirect()->route('company.internships')->with('info', 'Nenhuma oferta foi fechada, todas estão dentro do prazo.');
        }
    }

    // Metodo para listar todos os planos de estagis
    public function listPlans()
    {
        // User logado
        $user = Auth::user();
        
        // Obtem as ofertas de estagio do user logado
        $internship_offers = InternshipOffer::where('company_id', $user->company->id)->get();
        
        // Obtem os IDs das ofertas de estágio
        $internship_offer_ids = $internship_offers->pluck('id');

        // Obtem os planos de estagio associados às ofertas da empresa
        $internship_plans = InternshipPlan::whereIn('internship_offer_id', $internship_offer_ids)->get();
        
        return view('users.company.plans', [
            'internship_plans' => InternshipPlanResource::collection($internship_plans)->resolve() ?? [],
            'internship_offers' => InternshipOfferResource::collection($internship_offers)->resolve() ?? [],
        ]);
    }

    public function storePlan(Request $request)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'objectives' => 'required|string|max:1000',
            'planned_activities' => 'required|string|max:2000',
            'internship_offer_id' => 'required|exists:internship_offers,id', 
        ], [
            'start_date.before_or_equal' => 'A data de início deve ser anterior ou igual à data de fim',
            'end_date.after_or_equal' => 'A data de fim deve ser posterior ou igual à data de início',
            'planned_activities.required' => 'As atividades planeadas são obrigatórias',
            'internship_offer_id.exists' => 'A oferta de estágio selecionada não existe',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        $data['status'] = 'pending';

        // Obtem a oferta de estagio correspondente
        $internshipOffer = InternshipOffer::find($data['internship_offer_id']);
        
        // Verificar se a oferta de estagio tem um curso associado
        if (!$internshipOffer || !$internshipOffer->course_id) {
            return redirect()->back()->with('error', 'A oferta de estágio não tem um curso associado');
        }

        // Obtem o curso associado à oferta de estagio
        $course = Course::find($internshipOffer->course_id);
        
        // Procura a unidade curricular Estagio
        $unitCurricular = $course->unitsCurriculars()->whereIn('name', ['Estágio', 'Estagio', 'estagio', 'estágio'])->first();

        if (!$unitCurricular) {
            return redirect()->route('company.plans')->with('info', 'A unidade curricular "Estágio" não foi encontrada para o curso associado');
        }

         // Verifica se já existe um plano associado à oferta
        $existingPlan = InternshipPlan::where('internship_offer_id', $internshipOffer->id)->first();

        if ($existingPlan && $existingPlan->status !== 'rejected') {
            return redirect()->route('company.plans')->with('info', 'Não é possível criar um novo plano enquanto o plano existente não estiver rejeitado');
        }

        // Calcular o total de horas apartir do numero de ects da unidade curricular
        $totalHours = $unitCurricular->ects * 27; 

        // Cria o novo plano de estagio com o total de horas
        $internship_plan = InternshipPlan::create(array_merge($data, ['total_hours' => $totalHours]));

        if ($internship_plan) {
            // Retorna para a página dos planos de estagio com mensagem de sucesso
            return redirect()->route('company.plans')->with('success', 'Plano de estágio criado com sucesso!');
        } else {
            // Retorna para a página dos planos de estagio com mensagem de erro
            return redirect()->route('company.plans')->with('error', 'Erro ao criar o plano de estágio');
        }
    }
    
    // Metodo para listar todas os registos diarios
    public function listAttendance(){

        // User logado
        $user = Auth::user();

        // Obtem as ofertas de estagio da empresa do user logado
        $internship_offers = InternshipOffer::where('company_id', $user->company->id)->get();

        // Obtem os IDs das ofertas de estagio
        $internship_offer_ids = $internship_offers->pluck('id');
    
        // Obtem os registo de presenca associados as ofertas de estagio
        $attendance_records = AttendanceRecord::whereIn('internship_offer_id', $internship_offer_ids)->get();        

        // Retorne a view e passe as variáveis necessárias
        return view('users.company.attendances', [
            'attendance_records' => AttendanceRecordResource::collection($attendance_records)->resolve() ?? [],
            'internship_offers' => $internship_offers 
        ]);
    }

    // Metodo para aprovar registos diarios
    public function approveAttendance(Request $request, $id)
    {
        // Procura o registo de presenca pelo ID
        $attendanceRecord = AttendanceRecord::find($id);

        // Atualiza o status para Aprovado
        $attendanceRecord->approval_status = 'approved';

        // Guarda
        $attendanceRecord->save();

        return redirect()->route('company.attendance')->with('success', 'Registro de presença aprovado com sucesso!');
    }

    // Metodo para reprovar registos diarios
    public function disapproveAttendance(Request $request, $id)
    {
        // Procura o registo de presenca pelo ID
        $attendanceRecord = AttendanceRecord::find($id);

        // Atualiza o status para Reprovado
        $attendanceRecord->approval_status = 'rejected';

        // Guarda
        $attendanceRecord->save();

        return redirect()->route('company.attendance')->with('success', 'Registro de presença reprovado com sucesso!');
    }

    // Metodo para fazer a avaliacao no relatorio por parte da empresa
    public function listEvaluations()
    {
        // User logado
        $user = Auth::user();
    
        // Obtem as ofertas de estagios da empresa logada
        $internship_offers = InternshipOffer::where('company_id', $user->company->id)->get();
    
        // Obtem os relatorios finais associados as ofertas de estagios da empresa
        $final_reports = FinalReport::with('internshipOffer')->whereIn('internship_offer_id', $internship_offers->pluck('id'))->get();
    
        return view('users.company.evaluations', [
            'final_reports' => FinalReportResource::collection($final_reports)->resolve() ?? [],
            'internship_offers' => InternshipOfferResource::collection($internship_offers)->resolve() ?? []
        ]);
    }

    // Metodo para avaliar estagio por parte da empresa
    public function storeEvaluations(Request $request, $id)
    {
        // Validação dos dados da avalicao
        $request->validate([
            'company_evaluation' => 'required|string|min:0|max:20',
        ]);
    
        // Procura o relatório final pelo ID
        $finalReport = FinalReport::find($id);
    
        // Guarda a avalicao
        $finalReport->company_evaluation = $request->input('company_evaluation');

        // Guarda
        $finalReport->save();
    
        return redirect()->route('company.evaluations')->with('success', 'Avaliação feita com sucesso!');
    }
}
