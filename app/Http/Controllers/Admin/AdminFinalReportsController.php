<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinalReport; 
use Illuminate\Support\Str; 
use App\Http\Resources\FinalReportResource; 
use App\Models\InternshipOffer;
use App\Http\Resources\InternshipOfferResource;
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;


class AdminFinalReportsController extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenha as instituições
        $internship_offers = InternshipOffer::whereIn('status', ['archived', 'closed'])->get();

        $final_reports = FinalReport::with('internshipOffer')->get();

        return view('admin.final-reports', [
            'final_reports' => FinalReportResource::collection($final_reports)->resolve() ?? [],
            'internship_offers' => InternshipOfferResource::collection($internship_offers)->resolve() ?? []
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
            'internship_offer_id' => 'required|exists:internship_offers,id', 
            'final_report_file' => 'required|file|mimes:pdf|max:5000',
            'company_evaluation' => 'nullable|numeric|min:0|max:20', 
            'final_evaluation' => 'nullable|numeric|min:0|max:20', 
            'status' => 'nullable|string|in:submitted,rejected,evaluated', 
        ], [
            'internship_offer_id.required' => 'A oferta de estágio é obrigatória',
            'internship_offer_id.exists' => 'A oferta de estágio selecionada não existe',
            'company_evaluation.numeric' => 'A avaliação da empresa deve ser um número entre 0 e 20',
            'final_evaluation.numeric' => 'A avaliação final deve ser um número entre 0 e 20',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        
        // Calcular o total de horas aprovadas dos registos diarios apenas com status 'approved'
        $internshipOffer = InternshipOffer::find($data['internship_offer_id']);
        $totalApprovedHours = $internshipOffer->attendanceRecords()->where('approval_status', 'approved')->sum('approval_hours'); 

        $data['total_hours'] = $totalApprovedHours; 

        // Conta  os dias
        $totalDays = $internshipOffer->attendanceRecords()->where('approval_status', 'approved')->distinct('date')->count('date'); 
        
        $data['total_days'] = $totalDays; 

        // Recupera o tatal de horas registadas apartir do plano
        $totalHoursFromPlan = $internshipOffer->plans()->sum('total_hours'); 

        // Verifica se as total_hours registradas sao iguais ou superiores as horas exigidas no plano
        if ($totalApprovedHours < floatval($totalHoursFromPlan)) {
            return redirect()->back()->withErrors([
                'total_hours' => 'As horas registradas (' . $totalApprovedHours . ' horas) não correspondem às horas definidas no plano da oferta de estágio (' . $totalHoursFromPlan . ' horas).'
            ])->withInput();
        }

        // Upload do pdf do relatorio final
        if ($request->hasFile('final_report_file')) {

            $internshipOfferId = $data['internship_offer_id'];
            
            $internshipOffer = InternshipOffer::findOrFail($internshipOfferId);
            $title = $internshipOffer->title;

            $fileName = 'Relatorio_Final_' . str_replace(' ', '_', $title) . '.' . $request->file('final_report_file')->getClientOriginalExtension();

            $path = $request->file('final_report_file')->storeAs('final_reports', $fileName, 'public'); 
            $data['final_report_file_path'] = $path; 
        }   

        // Se houver avalicao tando da empresa como da instituicao
        if (!is_null($data['company_evaluation']) && !is_null($data['final_evaluation'])) {
            $data['status'] = 'evaluated'; // O status fica avaliado
        } else {
            $data['status'] = $data['status'] ?? 'submitted';
        }

        // Cria o novo relatório final
        $final_report = FinalReport::create($data);

        if ($final_report) {
            // Retorna para a página de relatórios finais com uma mensagem de sucesso
            return redirect()->route('admin.internship_final_reports.index')->with('success', 'Relatório final criado com sucesso!');
        } else {
            // Retorna para a página de relatórios finais com uma mensagem de erro
            return redirect()->route('admin.internship_final_reports.index')->with('error', 'Erro ao criar relatório final');
        }
    }

    /**
     * Display the specified internship offer.
     */
    public function show(FinalReport $final_report)
    {
        return view('admin.internship_final_reports.index', compact('final_report'));

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
    public function update(Request $request, FinalReport $final_report)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'company_evaluation' => 'nullable|numeric|min:0|max:20', 
            'final_evaluation' => 'nullable|numeric|min:0|max:20', 
            'status' => 'nullable|string|in:Submetido,Rejeitado,Avaliado', 
        ]);
        
        // Verifica se a validação falhou
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Converte o status para ingles como têm na bd
        switch ($data['status']) {
            case 'Submetido':
                $data['status'] = 'submitted';
                break;
            case 'Rejeitado':
                $data['status'] = 'rejected';
                break;
            case 'Avaliado':
                $data['status'] = 'evaluated';
                break;
        }
    

        // Faz a atualização do relatório final
        $update = $final_report->update($data);

        // Verifica se a atualização ocorreu com sucesso
        if ($update) {
            return redirect()->route('admin.internship_final_reports.index')->with('success', 'Relatório final atualizado com sucesso!');
        } else {
            return redirect()->route('admin.internship_final_reports.index')->with('error', 'Erro ao atualizar o relatório final');
        }
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(FinalReport $final_report)
    {
        $deleted = $final_report->delete();

        // Verificar se foi apagada
        if($deleted){
            return redirect()->route('admin.internship_final_reports.index')->with('success', 'Relatório excluído com sucesso!');

        }else
        {
            return redirect()->route('admin.internship_final_reports.index')->with('error', 'Erro ao excluir o relatório!');
        }
    }

    // Metodo para fazer o download do pdf 
    public function download($id)
    {
        $finalReport = FinalReport::findOrFail($id);

        if (Storage::disk('public')->exists($finalReport->final_report_file_path)) {
            return Storage::disk('public')->download($finalReport->final_report_file_path);
        }

        return redirect()->route('admin.internship_final_reports.index')->with('error', 'PDF não encontrado');
    }
}