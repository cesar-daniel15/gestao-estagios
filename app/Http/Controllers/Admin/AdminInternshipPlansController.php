<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipPlan;
use App\Models\InternshipOffer;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Http\Resources\InternshipPlanResource;
use App\Http\Resources\InternshipOfferResource;
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminInternshipPlansController extends Controller
{

    /**
     * Display a listing of the internship offers.
     */
    public function index()
    {
        $internship_plans = InternshipPlan::all(); 
        $internship_offers = InternshipOffer::all();
        
        return view('admin.internships-plans', [
            'internship_plans' => InternshipPlanResource::collection($internship_plans)->resolve() ?? [],
            'internship_offers' => InternshipOfferResource::collection($internship_offers)->resolve() ?? [],
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
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:pending,approved,rejected',
            'objectives' => 'required|string|max:1000',
            'planned_activities' => 'required|string|max:2000',
            'internship_offer_id' => 'required|exists:internship_offers,id', 
        ], [
            'start_date.before_or_equal' => 'A data de início deve ser anterior ou igual à data de fim',
            'end_date.after_or_equal' => 'A data de fim deve ser posterior ou igual à data de início',
            'status.required' => 'O status é obrigatório',
            'planned_activities.required' => 'As atividades planeadas são obrigatórias',
            'internship_offer_id.exists' => 'A oferta de estágio selecionada não existe',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Verifica se o status esta aprovado e muda o approved_by_uc
        $data['approved_by_uc'] = ($data['status'] === 'approved') ? 1 : 0;

        // Obtem a oferta de estágio correspondente
        $internshipOffer = InternshipOffer::find($data['internship_offer_id']);
        
        // Verificar se a oferta de estágio tem um curso associado
        if (!$internshipOffer || !$internshipOffer->course_id) {
            return redirect()->back()->with('error', 'A oferta de estágio não tem um curso associado');
        }

        // Obtem o curso associado à oferta de estágio
        $course = Course::find($internshipOffer->course_id);
        
        // Procura a unidade curricular Estagio
        $unitCurricular = $course->unitsCurriculars()->whereIn('name', ['Estágio', 'Estagio', 'estagio', 'estágio'])->first();

        if (!$unitCurricular) {
            return redirect()->route('admin.internships_plans.index')->with('info', 'A unidade curricular "Estágio" não foi encontrada para o curso associado');
        }

         // Verifica se já existe um plano associado à oferta
        $existingPlan = InternshipPlan::where('internship_offer_id', $internshipOffer->id)->first();

        if ($existingPlan && $existingPlan->status !== 'rejected') {
            return redirect()->route('admin.internships_plans.index')->with('info', 'Não é possível criar um novo plano enquanto o plano existente não estiver rejeitado');
        }

        // Calcular o total de horas apartir do numero de ects da unidade curricular
        $totalHours = $unitCurricular->ects * 27; 

        // Cria o novo plano de estágio com o total de horas
        $internship_plan = InternshipPlan::create(array_merge($data, ['total_hours' => $totalHours]));

        if ($internship_plan) {
            // Retorna para a página dos planos de estágio com mensagem de sucesso
            return redirect()->route('admin.internships_plans.index')->with('success', 'Plano de estágio criado com sucesso!');
        } else {
            // Retorna para a página dos planos de estágio com mensagem de erro
            return redirect()->route('admin.internships_plans.index')->with('error', 'Erro ao criar o plano de estágio');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InternshipPlan $internship_plan)
    {

        // Return para a view com os dados
        return view('admin.internship_plans.index', compact('internship_plan'));
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
    public function update(Request $request, InternshipPlan $internship_plan)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'total_hours' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_orequal:start_date',
            'status' => 'nullable|string',
            'objectives' => 'nullable|string|max:5000',
            'planned_activities' => 'nullable|string|max:2000',
        ], [
            'total_hours.integer' => 'O total de horas deve ser um número inteiro',
            'start_date.before_or_equal' => 'A data de início deve ser anterior ou igual à data de fim',
            'end_date.after_or_equal' => 'A data de fim deve ser posterior ou igual à data de início',
            'objectives.string' => 'Os objetivos devem ser uma string.',
            'planned_activities.string' => 'As atividades planeadas devem ser uma string.',
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Converte o status para ingles como têm na bd
        switch ($data['status']) {
            case 'Pendente':
                $data['status'] = 'pending';
                break;
            case 'Aprovado':
                $data['status'] = 'approved';
                break;
            case 'Rejeitado':
                $data['status'] = 'rejected';
                break;
        }
        
        // Verifica se o status esta aprovado e muda o approved_by_uc
        $data['approved_by_uc'] = ($data['status'] === 'approved') ? 1 : 0;
            
        // Faz a atualização
        $update = $internship_plan->update($data);
    
        // Verifica se a atualização ocorreu
        if ($update) {
            return redirect()->route('admin.internships_plans.index')->with('success', 'Plano de estágio atualizado com sucesso!');
        } else {
            return redirect()->route('admin.internships_plans.index')->with('error', 'Erro ao atualizar o plano de estágio');
        }
    }

    /**
     * Remove the specified internship plan from storage.
     */
    public function destroy(InternshipPlan $internship_plan)
    {
        // Remove o plano de estágio da base de dados
        $deleted = $internship_plan->delete();

        // Verificar se o plano foi excluído
        if ($deleted) {
            return redirect()->route('admin.internships_plans.index')->with('success', 'Plano de estágio excluído com sucesso!');
        } else {
            return redirect()->route('admin.internships_plans.index')->with('error', 'Erro ao excluir o plano de estágio');
        }
    }
}