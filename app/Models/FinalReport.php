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
        'total_hours',          
        'total_days',          
        'final_report_content',
        'company_evaluation',   
        'final_evaluation',    
        'status',        
    ];

    // Relacao com a tabela Internship Ofers
    public function internshipOffer()
    {
        return $this->hasOne(InternshipOffer::class, 'final_report_id');
    }
}
