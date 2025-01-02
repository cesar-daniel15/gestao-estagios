<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipOffer;
use App\Models\Company;
use App\Models\Institution;
use App\Models\Course;
use App\Models\InternshipPlan;
use App\Models\FinalReport;
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
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\App;

class AdminInternshipOffersController extends Controller
{
    /**
     * Display a listing of the internship offers.
     */
    public function index()
    {
        // Obter as ofertas de estágio com os relacionamentos necessários
        $internship_offers = InternshipOffer::with(['company', 'institution', 'course', 'plans'])->get();
    
        // Obter todas as empresas
        $companies = Company::all();
    
        // Obter todas as instituições
        $institutions = Institution::all();
    
        // Obter todos os cursos
        $courses = Course::all();
    
        // Obter todos os planos
        $internship_plans = InternshipPlan::all(); // Adicionar consulta para planos
    
        $finalReports = FinalReport::all();

        // Corrigir a referência à view para corresponder ao arquivo correto
        return view('admin.internships-offers', [
            'internship_offers' => InternshipOfferResource::collection($internship_offers)->resolve() ?? [],
            'companies' => $companies, 
            'institutions' => $institutions, 
            'courses' => $courses, 
            'internship_plans' => $internship_plans, 
            'finalReports' => $finalReports, 
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
            'final_report_id' => 'nullable|exists:final_reports,id',
            'status' => 'nullable|in:open,closed,archived',
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'status' => 'required|in:Aberto,Fechado,Arquivado', // Aceita os valores em português
        ]);

        // Verifica se a validacao falhou
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Converte o status para ingles como têm na bd
        switch ($data['status']) {
            case 'Aberto':
                $data['status'] = 'open';
                break;
            case 'Fechado':
                $data['status'] = 'closed';
                break;
            case 'Arquivado':
                $data['status'] = 'archived';
                break;
        }
    
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

   // Método para atualizar o status de todas as ofertas que já passaram do prazo aceito
    public function closeOffer()
    {
        // Data de hoje
        $today = Carbon::now()->toDateString(); 

        // Encontra todas as ofertas abertas cuja data limite já passou
        $offers = InternshipOffer::where('status', 'open')->where('deadline', '<', $today)->get();
        
        if ($offers->isEmpty()) {
            return redirect()->route('admin.internships_offers.index');
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
            return redirect()->route('admin.internships_offers.index')->with('info', 'Algumas ofertas foram fechadas');
        } else {
            return redirect()->route('admin.internships_offers.index')->with('info', 'Nenhuma oferta foi fechada, todas estão dentro do prazo.');
        }
    }

    //  Metodo para fazer download da oferta em PDF
    public function download($id)
    {
        $internship_offer = InternshipOffer::with(['company', 'institution', 'course'])->findOrFail($id);
        
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);

        $html = view('pdf.internship_offer', ['internship_offer' => $internship_offer])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = $internship_offer->title . '.pdf';

        return $dompdf->stream($fileName, ['Attachment' => true]);
    }
}