<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinalReport extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'final_reports';
    
    // Campos
    protected $fillable = [
        'internship_offer_id', 
        'total_hours',          
        'total_days',          
        'final_report_file_path',
        'company_evaluation',   
        'final_evaluation',    
        'status',        
    ];

    // Relacao com a tabela Internship Ofers
    public function internshipOffer()
    {
        return $this->belongsTo(InternshipOffer::class, 'internship_offer_id'); 
    }
}
