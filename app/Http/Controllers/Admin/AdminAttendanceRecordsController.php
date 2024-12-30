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
use Carbon\Carbon;

class AdminAttendanceRecordsController extends Controller
{
    /**
     * Display a listing of the internship offers.
     */
    public function index()
    {
        // Obtenha os registros de presença
        $attendance_records = AttendanceRecord::all();
    
        $internship_offers = InternshipOffer::all(); 
    
        // Retorne a view e passe as variáveis necessárias
        return view('admin.attendance-records', [
            'attendance_records' => AttendanceRecordResource::collection($attendance_records)->resolve() ?? [],
            'internship_offers' => $internship_offers 
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
            'internship_offer_id' => 'required|exists:internship_offers,id', 
            'date' => 'required|date|unique:attendance_records,date,NULL,id,internship_offer_id,' . $request->internship_offer_id,
            'morning_start_time' => 'required|date_format:H:i', 
            'morning_end_time' => 'required|date_format:H:i|after:morning_start_time', 
            'afternoon_start_time' => 'required|date_format:H:i',
            'afternoon_end_time' => 'required|date_format:H:i|after:afternoon_start_time', 
            'summary' => 'required|string|max:1000',
        ], [
            'internship_offer_id.exists' => 'O estágio selecionado não existe',
            'date.date' => 'A data informada não é válida',
            'date.unique' => 'Esse dia já foi registado',
            'morning_start_time.date_format' => 'O horário de início da manhã não está no formato correto',
            'morning_end_time.after' => 'O horário de fim da manhã deve ser depois do início',
            'afternoon_start_time.date_format' => 'O horário de início da tarde não está no formato correto',
            'afternoon_end_time.after' => 'O horário de fim da tarde deve ser depois do início',
        ]);
        
        // Se a validação falhar, retorna para a página anterior com os erros
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Obtém os dados validados
        $data = $validator->validated();
    
        // Calcula o tempo total de aprovacao em segundos
        $morningHours = strtotime($data['morning_end_time']) - strtotime($data['morning_start_time']);
        $afternoonHours = strtotime($data['afternoon_end_time']) - strtotime($data['afternoon_start_time']);
        $totalSeconds = $morningHours + $afternoonHours;
        
        // Converte o tempo total para o formato HH:MM
        $formattedApprovalTime = gmdate('H:i', $totalSeconds);

        $data['approval_hours'] = $formattedApprovalTime; 
        $data['approval_status'] = 'pending'; 
    
        // Cria um novo registro de presença
        $attendanceRecord = AttendanceRecord::create($data);
    
        // Verifica se o registro foi criado com sucesso
        if ($attendanceRecord) {
            return redirect()->route('admin.internship_attendance_records.index')->with('success', 'Registro de presença criado com sucesso!');
        } else {
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
            'approval_status' => 'nullable|string',
            'date' => 'nullable|date',
            'morning_start_time' => 'nullable|date_format:H:i',
            'morning_end_time' => 'nullable|date_format:H:i|after_or_equal:morning_start_time',
            'afternoon_start_time' => 'nullable|date_format:H:i',
            'afternoon_end_time' => 'nullable|date_format:H:i|after_or_equal:afternoon_start_time',
            'summary' => 'nullable|string|max:255',
        ]);
    
        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Obtenção dos dados validados
        $data = $validator->validated();

        switch ($data['approval_status']) {
            case 'Pendente':
                $data['approval_status'] = 'pending';
                break;
            case 'Aprovado':
                $data['approval_status'] = 'approved';
                break;
            case 'Rejeitado':
                $data['approval_status'] = 'rejected';
                break;
        }
        
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