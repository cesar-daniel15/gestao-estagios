<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipOffer;
use App\Models\Company;
use App\Models\Institution;
use App\Models\Course;
use App\Models\InternshipPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Http\Resources\InternshipOfferResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\InstitutionResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\InternshipPlanResource;
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;

class AdminInternshipOffersController extends Controller
{
    /**
     * Display a listing of the internship offers.
     */
    public function index()
    {
        // Obter as ofertas de estágio com os relacionamentos necessários
        $internship_offers = InternshipOffer::with(['company', 'institution', 'course'])->get();
    
        // Obter todas as empresas
        $companies = Company::all();
    
        // Obter todas as instituições
        $institutions = Institution::all();
    
        // Obter todos os cursos
        $courses = Course::all();
    
        // Obter todos os planos
        $internship_plans = InternshipPlan::all(); // Adicionar consulta para planos
    
        // Corrigir a referência à view para corresponder ao arquivo correto
        return view('admin.internships-offers', [
            'internship_offers' => InternshipOfferResource::collection($internship_offers)->resolve() ?? [],
            'companies' => $companies, // Passar as empresas para a view
            'institutions' => $institutions, // Passar as instituições para a view
            'courses' => $courses, // Passar os cursos para a view
            'internship_plans' => $internship_plans, // Passar os planos para a view
        ]);
    }
    


    /**
     * Display the specified internship offer.
     */
    public function create()
    {
        
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'institution_id' => 'required|exists:institutions,id',
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'nullable|date',
            'plan_id' => 'nullable|exists:internship_plans,id',
            'final_report_id' => 'nullable|exists:final_reports,id',
            'status' => 'required|in:active,inactive',
        ]);

       // Se a valicao falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Cria a nova oferta de estágio
        $internship_offer = InternshipOffer::create($data);

        if ($internship_offer) {
            return redirect()->route('admin.internships_offers.index')->with('success', 'Oferta de estágio criada com sucesso!');
        } else {
            return redirect()->route('admin.internships_offers.index')->with('error', 'Erro ao criar a oferta de estágio.');
        }
    }

    /**
     * Display the specified internship offer.
     */
    public function show(InternshipOffer $internship_offer)
    {
        return view('admin.internship_offers.show', [
            'internship_offer' => $internship_offer->load(['company', 'institution', 'course']),
        ]);
    }

    /**
     * Show the form for editing the specified internship offer.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified internship offer in storage.
     */
    public function update(Request $request, InternshipOffer $internship_offer)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'institution_id' => 'required|exists:institutions,id',
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'nullable|date',
            'plan_id' => 'nullable|exists:internship_plans,id',
            'final_report_id' => 'nullable|exists:final_reports,id',
            'status' => 'required|in:active,inactive',
        ]);

        // Verifica se a validacao falhou
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Faz a atualizacao
        $updated = $internship_offer->update($data);

        if ($updated) {
            return redirect()->route('admin.internships_offers.index')->with('success', 'Oferta de estágio atualizada com sucesso!');
        }

        return redirect()->route('admin.internships_offers.index')->with('error', 'Erro ao atualizar a oferta de estágio.');
    }

    /**
     * Remove the specified internship offer from storage.
     */
    public function destroy(InternshipOffer $internship_offer)
    {
        $deleted = $internship_offer->delete();

        if ($deleted) {
            return redirect()->route('admin.internships_offers.index')->with('success', 'Oferta de estágio excluída com sucesso!');
        }

        return redirect()->route('admin.internships_offers.index')->with('error', 'Erro ao excluir a oferta de estágio.');
    }
}