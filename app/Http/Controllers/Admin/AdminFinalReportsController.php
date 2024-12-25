<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinalReport; 
use Illuminate\Support\Str; 
use App\Http\Resources\FinalReportResource; 
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
        $final_reports = FinalReport ::all();

        return view('admin.final-reports', [
            'final_reports' => FinalReportResource::collection($final_reports)->resolve() ?? []
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
            'total_hours' => 'required|numeric|min:0',
            'total_days' => 'required|numeric|min:0',
            'final_report_content' => 'required|string|max:5000',
            'company_evaluation' => 'nullable|string|max:5000',
            'final_evaluation' => 'nullable|string|max:5000',
            'status' => 'required|string|in:pending,approved,rejected', // Exemplo de status
        ], [
            'total_hours.required' => 'O campo de horas totais é obrigatório.',
            'total_days.required' => 'O campo de dias totais é obrigatório.',
            'final_report_content.required' => 'O conteúdo do relatório final é obrigatório.',
            'status.in' => 'O status deve ser um dos seguintes: pending, approved, rejected.',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Cria o novo relatório final
        $final_report = FinalReport::create($data);

        if ($final_report) {
            // Se necessário, aqui você pode adicionar lógica para salvar outros arquivos, imagens ou dados associados.
            // Por exemplo, se houver um campo para anexar arquivos, como documentos relacionados ao relatório:
            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('final_reports/attachments', 'public');
                $final_report->update(['attachment' => $path]);
            }

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
            'total_hours' => 'nullable|numeric|min:0',
            'total_days' => 'nullable|numeric|min:0',
            'final_report_content' => 'nullable|string|max:5000',
            'company_evaluation' => 'nullable|string|max:5000',
            'final_evaluation' => 'nullable|string|max:5000',
            'status' => 'nullable|string|in:pending,approved,rejected', // Exemplos de status
            'attachment' => 'nullable|file|mimes:pdf,docx,txt|max:5000', // Arquivo do relatório (se aplicável)
        ], [
            'status.in' => 'O status deve ser um dos seguintes: pending, approved, rejected.',
            'attachment.mimes' => 'O arquivo anexado deve ser um dos seguintes tipos: pdf, docx, txt.',
            'attachment.max' => 'O arquivo anexado não pode ser maior que 5MB.',
        ]);
        
        // Verifica se a validação falhou
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Verifica se há um novo arquivo de anexo e o processa
        if ($request->hasFile('attachment')) {
            // Apaga o anexo antigo, se existir
            if ($final_report->attachment && Storage::disk('public')->exists($final_report->attachment)) {
                Storage::disk('public')->delete($final_report->attachment);
            }

            // Guarda o novo anexo
            $path = $request->file('attachment')->store('final_reports/attachments', 'public');
            $data['attachment'] = $path; // Atualiza o caminho no array de dados
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
}
