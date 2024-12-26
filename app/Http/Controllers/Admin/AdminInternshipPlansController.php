<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Http\Resources\InternshipPlanResource; 
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;

class AdminInternshipPlansController extends Controller
{

    /**
     * Display a listing of the internship offers.
     */
    public function index()
    {
        $internship_plans = InternshipPlan ::all();

        return view('admin.internships-plans', [
            'internship_plans' => InternshipPlanResource::collection($internship_plans)->resolve() ?? [],
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
            'total_hours' => 'required|integer|min:1',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'objectives' => 'required|string|max:1000',
            'planned_activities' => 'required|string|max:2000',
            'approved_by_uc' => 'required|boolean',
            'status' => 'required|string|in:pending,approved,rejected',
        ], [
            'total_hours.required' => 'O total de horas é obrigatório.',
            'total_hours.integer' => 'O total de horas deve ser um número inteiro.',
            'start_date.before_or_equal' => 'A data de início deve ser anterior ou igual à data de término.',
            'end_date.after_or_equal' => 'A data de término deve ser posterior ou igual à data de início.',
            'objectives.required' => 'Os objetivos são obrigatórios.',
            'planned_activities.required' => 'As atividades planejadas são obrigatórias.',
            'approved_by_uc.required' => 'É necessário especificar se o plano foi aprovado pela UC.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser "pending", "approved" ou "rejected".',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Cria o novo plano de estágio
        $internship_plan = InternshipPlan::create($data);

        if ($internship_plan) {
            // Retorna para a página dos planos de estágio com mensagem de sucesso
            return redirect()->route('admin.internships_plans.index')->with('success', 'Plano de estágio criado com sucesso!');
        } else {
            // Retorna para a página dos planos de estágio com mensagem de erro
            return redirect()->route('admin.internships_plans.index')->with('error', 'Erro ao criar o plano de estágio.');
        }
    }

    
    /**
     * Display the specified resource.
     */
    public function show(InternshipPlan $internship_plans)
    {

        // Return para a view com os dados
        return view('admin.internship_plans.index', compact('internship_plans'));
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
    public function update(Request $request, InternshipPlan $internshipPlan)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'total_hours' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'objectives' => 'nullable|string|max:1000',
            'planned_activities' => 'nullable|string|max:2000',
            'approved_by_uc' => 'nullable|boolean',
            'status' => 'nullable|string|in:pending,approved,rejected',
        ], [
            'total_hours.integer' => 'O total de horas deve ser um número inteiro.',
            'start_date.before_or_equal' => 'A data de início deve ser anterior ou igual à data de término.',
            'end_date.after_or_equal' => 'A data de término deve ser posterior ou igual à data de início.',
            'objectives.string' => 'Os objetivos devem ser uma string.',
            'planned_activities.string' => 'As atividades planejadas devem ser uma string.',
            'approved_by_uc.boolean' => 'A aprovação pela UC deve ser um valor booleano.',
            'status.in' => 'O status deve ser "pending", "approved" ou "rejected".',
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = $validator->validated();
    
        // Faz a atualização
        $update = $internshipPlan->update($data);
    
        // Verifica se a atualização ocorreu
        if ($update) {
            return redirect()->route('admin.internships_plans.index')->with('success', 'Plano de estágio atualizado com sucesso!');
        } else {
            return redirect()->route('admin.internships_plans.index')->with('error', 'Erro ao atualizar o plano de estágio.');
        }
    }

    /**
     * Remove the specified internship plan from storage.
     */
    public function destroy(InternshipPlan $internshipPlan)
    {
        // Remove o plano de estágio da base de dados
        $deleted = $internshipPlan->delete();

        // Verificar se o plano foi excluído
        if ($deleted) {
            return redirect()->route('admin.internships_plans.index')->with('success', 'Plano de estágio excluído com sucesso!');
        } else {
            return redirect()->route('admin.internships_plans.index')->with('error', 'Erro ao excluir o plano de estágio');
        }
    }
}