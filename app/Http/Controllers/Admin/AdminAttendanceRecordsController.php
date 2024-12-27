<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Importe corretamente o Controller base
use Illuminate\Http\Request;
use App\Models\AttendanceRecord;
use App\Models\InternshipOffer;
use Illuminate\Support\Str; 
use App\Http\Resources\AttendanceRecordResource;
use App\Http\Resources\InternshipOfferResource;
use Illuminate\Support\Facades\Validator; 
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage; 


class AdminAttendanceRecordsController extends Controller
{
    /**
     * Display a listing of the internship offers.
     */
    public function index()
    {
        // Obtenha os registros de presença
        $attendance_records = AttendanceRecord::all();
    
        // Obtenha as ofertas de estágio
        $internship_offers = InternshipOffer::all(); 
    
        // Retorne a view e passe as variáveis necessárias
        return view('admin.attendance-records', [
            'attendance_records' => AttendanceRecordResource::collection($attendance_records)->resolve() ?? [],
            'internship_offers' => $internship_offers // Passando as ofertas de estágio para a view
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
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'internship_offer_id' => 'required|exists:internship_offers,id', // Valida se o estágio existe
            'date' => 'required|date', // Valida se a data é válida
            'morning_start_time' => 'required|date_format:H:i', // Valida se o horário de início da manhã está no formato correto
            'morning_end_time' => 'required|date_format:H:i|after:morning_start_time', // Valida se o horário de término da manhã é depois do início
            'afternoon_start_time' => 'required|date_format:H:i', // Valida se o horário de início da tarde está no formato correto
            'afternoon_end_time' => 'required|date_format:H:i|after:afternoon_start_time', // Valida se o horário de término da tarde é depois do início
            'approval_hours' => 'required|numeric|min:0', // Valida se as horas de aprovação são um número positivo
            'summary' => 'nullable|string|max:1000', // Valida o campo sumário (opcional)
        ], [
            'internship_offer_id.exists' => 'O estágio selecionado não existe.',
            'date.date' => 'A data informada não é válida.',
            'morning_start_time.date_format' => 'O horário de início da manhã não está no formato correto.',
            'morning_end_time.after' => 'O horário de término da manhã deve ser depois do início.',
            'afternoon_start_time.date_format' => 'O horário de início da tarde não está no formato correto.',
            'afternoon_end_time.after' => 'O horário de término da tarde deve ser depois do início.',
            'approval_hours.numeric' => 'As horas de aprovação devem ser um número.',
            'sumamry.max' => 'O sumário não pode ter mais de 1000 caracteres.',
        ]);

        // Se a validação falhar, retorna para a página anterior com os erros
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtém os dados validados
        $data = $validator->validated();

        // Cria um novo registro de presença
        $attendanceRecord = AttendanceRecord::create($data);

        // Verifica se o registro foi criado com sucesso
        if ($attendanceRecord) {
            // Redireciona para a página de registros de presença com uma mensagem de sucesso
            return redirect()->route('admin.internship_attendance_records.index')->with('success', 'Registro de presença criado com sucesso!');
        } else {
            // Caso ocorra um erro ao criar o registro, retorna com uma mensagem de erro
            return redirect()->route('admin.internship_attendance_records.index')->with('error', 'Erro ao criar registro de presença.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceRecord $attendance_record)
    {
       
        return view('admin.internship_attendance_records.index', compact('attendance_record'));
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
    public function update(Request $request, AttendanceRecord $attendance_record)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'internship_offer_id' => 'required|exists:internship_offers,id',
            'date' => 'required|date',
            'morning_start_time' => 'required|date_format:H:i',
            'morning_end_time' => 'required|date_format:H:i|after_or_equal:morning_start_time',
            'afternoon_start_time' => 'required|date_format:H:i',
            'afternoon_end_time' => 'required|date_format:H:i|after_or_equal:afternoon_start_time',
            'approval_hours' => 'required|numeric|min:0',
            'summary' => 'nullable|string|max:255',
        ], [
            'internship_offer_id.required' => 'A oferta de estágio é obrigatória.',
            'date.required' => 'A data é obrigatória.',
            'morning_start_time.required' => 'O horário de início da manhã é obrigatório.',
            'morning_end_time.required' => 'O horário de término da manhã é obrigatório.',
            'morning_end_time.after_or_equal' => 'O horário de término da manhã deve ser igual ou posterior ao horário de início.',
            'afternoon_start_time.required' => 'O horário de início da tarde é obrigatório.',
            'afternoon_end_time.required' => 'O horário de término da tarde é obrigatório.',
            'afternoon_end_time.after_or_equal' => 'O horário de término da tarde deve ser igual ou posterior ao horário de início.',
            'approval_hours.required' => 'As horas de aprovação são obrigatórias.',
            'approval_hours.numeric' => 'As horas de aprovação devem ser um número.',
            'approval_hours.min' => 'As horas de aprovação não podem ser menores que 0.',
            'summary.string' => 'O resumo deve ser uma string.',
            'summary.max' => 'O resumo não pode ter mais de 255 caracteres.',
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Obtenção dos dados validados
        $data = $validator->validated();
    
        // Atualiza o registro de presença de estágio
        $update = $attendance_record->update($data);
    
        // Verifica se a atualização foi bem-sucedida
        if ($update) {
            return redirect()->route('admin.internship_attendance_records.index')->with('success', 'Registro de presença atualizado com sucesso!');
        } else {
            return redirect()->route('admin.internship_attendance_records.index')->with('error', 'Erro ao atualizar o registro de presença');
        }
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(AttendanceRecord $attendance_record)
    {
        // Tenta remover o registro de presença de estágio da base de dados
        $deleted = $attendance_record->delete();

        // Verificar se foi apagado com sucesso
        if ($deleted) {
            return redirect()->route('admin.internship_attendance_records.index')->with('success', 'Registro de presença excluído com sucesso!');
        } else {
            return redirect()->route('admin.internship_attendance_records.index')->with('error', 'Erro ao excluir o registro de presença');
        }
    }
}