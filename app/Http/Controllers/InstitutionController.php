<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Institution; 
use App\Models\Course;
use App\Models\Student;
use App\Models\UnitCurricular; 
use App\Models\UcResponsible; 
use App\Models\UcToResponsible;
use App\Models\UcToStudent;
use App\Models\InternshipOffer;
use App\Models\FinalReport;
use Illuminate\Support\Str; 
use App\Http\Resources\InstitutionResource; 
use App\Http\Resources\CourseResource; 
use App\Http\Resources\UnitResource;
use App\Http\Resources\UcResponsibleResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\FinalReportResource;
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->profile !== 'Institution') {
            return redirect()->back()->with('error', 'Você não tem permissão para eceder a esta página.');
        }

        $user = Auth::user();

        $institution = $user->institution;

        // Conta o total de cursos 
        $totalCourses = Course::where('institution_id', $institution->id)->count();

        // Conta o total de unidades curriculares pertencente ao curso que esta ligado a instituicao logada
        $totalUCs = Course::where('institution_id', $institution->id)->withCount('unitsCurriculars')->get()->sum('units_curriculars_count');

        // Obtem as unidades curriculares diretamente através dos cursos da instituição
        $unitsCurriculars = UnitCurricular::whereIn('course_id', Course::where('institution_id', $institution->id)->pluck('id'))->pluck('id');

        // Obtem o registro total de alunos por unidade curricular
        $userRegistration  = UcToStudent::selectRaw('lective_year as date, COUNT(*) as count')->whereIn('uc_id', $unitsCurriculars)->groupBy('lective_year') ->orderBy('lective_year')->get();

        return view('users.institution.dashboard', compact('user', 'totalCourses', 'totalUCs','userRegistration'));
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
        $institution = $user->institution; 
    
        // Validação
        $validator = Validator::make($request->all(), [
            'acronym' => 'required|string|max:5|unique:institutions,acronym' . ($institution ? ',' . $institution->id : ''),
            'phone' => 'required|string|max:9|unique:institutions,phone' . ($institution ? ',' . $institution->id : ''),
            'address' => 'required|string|max:255',
            'website' => 'required|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'acronym.required' => 'O campo acronimo é obrigatório',
            'acronym.unique' => 'A acronimo já está em uso',
            'phone.required' => 'O campo telefone é obrigatório',
            'phone.unique' => 'O telefone já está em uso',
            'address.required' => 'O campo morada é obrigatório',
            'website.required' => 'O campo website é obrigatório',
            'website.url' => 'O campo website deve ser uma URL válida',
            'logo.image' => 'O arquivo deve ser uma imagem',
            'logo.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif, svg',
            'logo.max' => 'A imagem não pode ter mais de 2048 KB',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $validator->validated();
    
        if ($institution) {
            // Se a instituicao ja existir faz update 
            $institution->update($data);
    
            // Verifica se o logo foi enviado e faz o upload
            if ($request->hasFile('logo')) {
                // Apaga o logo antigo
                if ($institution->logo && Storage::exists($institution->logo)) {
                    Storage::delete($institution->logo);
                }
                $path = $request->file('logo')->store('images/uploads', 'public');
                $institution->update(['logo' => $path]);
            }
    
            return redirect()->route('institution.profile')->with('success', 'Perfil atualizado com sucesso!');
        } else {
            // Cria uma nova instituicao
            $institution = Institution::create($data);
    
            // Associar a instituicao ao user logado
            $user->id_institution = $institution->id;
            $user->save();
    
            // Verifica se o logo foi enviado e faz o upload
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('images/uploads', 'public');
                $institution->update(['logo' => $path]);
            }
    
            return redirect()->route('institution.profile')->with('success', 'Perfil concluído com sucesso!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        $institution = $user->institution ?? null;

        return view('users.institution.profile', compact('user', 'institution'));
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
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'acronym' => 'required|string|max:10',  
            'phone' => 'required|string|max:11|unique:institutions,phone,' . $institution->id,
            'address' => 'required|string|max:255',
            'website' => 'url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Dados validados
        $validated = $validator->validated();
    
        // Prepara os dados para atualizar
        $dataToUpdate = [];
    
        // Verifica se cada campo foi alterado e se sim adiciona os ao array de atualizacao
    
        if ($validated['acronym'] != $institution->acronym) {
            $dataToUpdate['acronym'] = $validated['acronym'];
        }
    
        if ($validated['phone'] != $institution->phone) {
            $dataToUpdate['phone'] = $validated['phone'];
        }
    
        if ($validated['address'] != $institution->address) {
            $dataToUpdate['address'] = $validated['address'];
        }
    
        if ($validated['website'] != $institution->website) {
            $dataToUpdate['website'] = $validated['website'];
        }
    
        if ($request->hasFile('logo')) {
            // Apaga o logo antigo
            if ($institution->logo && Storage::exists($institution->logo)) {
                Storage::delete($institution->logo);
            }
            
            // Faz update do logo
            $path = $request->file('logo')->store('images/uploads', 'public');
            $institution->logo = $path;
        }

        // Faz a atualizacao
        $update = $institution->update($dataToUpdate);
    
        // Verifica se a atualizacao ocorreu
        if ($update) {
            return redirect()->route('institutions.profile')->with('success', 'Perfil atualizado com sucesso!');

        } else {
            return redirect()->route('institutions.profile')->with('error', 'Erro ao atualizar perfil');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Listar todos os cursos da instituicao logada
    public function listCourses() {
        
        // User logado
        $user = Auth::user();

        // Instituicao associada ao user
        $institution = $user->institution;

        // Obtem todos os cursos associados a instituicao
        $courses = Course::where('institution_id', $institution->id)->get();

        $courses = CourseResource::collection($courses)->resolve();

        // Retorna a view com os cursos
        return view('users.institution.courses', compact('courses'));
    }

    // Listar todas as unidade curriculares da instituicao logada
    public function listUcs() {

        // User logado
        $user = Auth::user();
    
        // Instituicao associada ao user
        $institution = $user->institution;
    
        // Obtem todos os cursos associados a instituição
        $courses = Course::where('institution_id', $institution->id)->get();
    
        // Obtem todas as unidades curriculares associadas aos cursos
        $unitsCurriculars = UnitCurricular::whereIn('course_id', $courses->pluck('id'))->get();
    
        $unitsCurriculars = UnitResource::collection($unitsCurriculars)->resolve();
    
        // Retorna a view com as unidades curriculares e cursos
        return view('users.institution.units-curriculars', compact('unitsCurriculars', 'courses'));
    }

    // Listar todos os responsáveis de UCs da instituição logada
    public function listUcResponsible() {
        // User logado
        $user = Auth::user();

        // Instituição associada ao user
        $institution = $user->institution;

        // Verifica se a instituição existe
        if (!$institution) {
            return redirect()->back()->with('error', 'Instituição não encontrada.');
        }

        // Obtem todos os cursos associados à instituição
        $courses = Course::where('institution_id', $institution->id)->pluck('id');

        // Obtem todas as unidades curriculares associadas aos cursos
        $unitsCurriculars = UnitCurricular::whereIn('course_id', $courses)->get();

        // Obtem todos os responsáveis associados às unidades curriculares
        $responsaveisIds = UcToResponsible::whereIn('uc_id', $unitsCurriculars->pluck('id'))->pluck('uc_responsible_id');

        // Obtem os responsáveis a partir dos IDs
        $responsaveis = UcResponsible::whereIn('id', $responsaveisIds)->get();

        $responsaveis = UcResponsibleResource::collection($responsaveis)->resolve();

        // Retorna a view com os responsáveis
        return view('users.institution.uc-responsibles', compact('responsaveis'));
    }

    // Listar todos os students da instituicao logada
    public function listStudents() {
        // User logado
        $user = Auth::user();
    
        // Instituição associada ao user
        $institution = $user->institution;
    
        $courses = Course::where('institution_id', $institution->id)->get();

        // Listar todos os alunos da instituição logada através da tabela uc_to_students
        $students = UcToStudent::with(['student', 'unitCurricular'])
            ->whereHas('unitCurricular.course', function($query) use ($institution) {
                $query->where('institution_id', $institution->id); 
            })->get()->pluck('student'); 

        $students = StudentResource::collection($students)->resolve();
    
        // Retorna a view com os alunos
        return view('users.institution.students', compact('students','courses'));
    }
    

   // Listar todas as ofertas de estágio de alunos da instituição
    public function listInternships() {
        // User logado
        $user = Auth::user();
        
        // Instituição associada ao user
        $institution = $user->institution;

        // Obter todos os cursos da instituição
        $courses = Course::where('institution_id', $institution->id)->pluck('id');

        // Obter todas as unidades curriculares associadas aos cursos
        $unitsCurriculars = UnitCurricular::whereIn('course_id', $courses)->pluck('id');

        // Obter todos os alunos da instituição com estágios
        $studentsWithInternships = UcToStudent::with(['student'])
            ->whereIn('uc_id', $unitsCurriculars)
            ->whereHas('student', function($query) {
                $query->whereNotNull('assigned_internship_id');
            })
            ->get()
            ->pluck('student');

        // Obter os IDs dos estágios
        $internshipIds = $studentsWithInternships->pluck('assigned_internship_id')->unique(); 

        // Obter todos os final_reports associados aos estágios
        $final_reports = FinalReport::whereIn('internship_offer_id', $internshipIds)->get(); 
        
        $final_reports = FinalReportResource::collection($final_reports)->resolve();
        
        return view('users.institution.internships', compact('final_reports'));
    }

    public function finalEvaluation(Request $request, $id) {
        // Validacao
        $validator = Validator::make($request->all(), [
            'final_evaluation' => 'nullable|numeric|min:0|max:20', 
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Encontrar o relatorio final pelo ID
        $finalReport = FinalReport::findOrFail($id);
    
        // Atualizar a avalicao final
        $finalReport->final_evaluation = $request->input('final_evaluation');
    
        // Atualizar o status para avaliado
        $finalReport->status = 'evaluated';
    
        $finalReport->save();
    
        return redirect()->route('institution.internships')->with('success', 'Avaliação final atualizada com sucesso!');
    }
}
