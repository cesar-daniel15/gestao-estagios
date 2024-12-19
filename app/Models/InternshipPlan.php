<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternshipPlan extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'internship_plans';

    // Campos
    protected $fillable = [
        'total_hours',        
        'start_date',          
        'end_date',           
        'objectives',          
        'planned_activities', 
        'approved_by_uc',     
        'status',      
    ];

    //  Relacao com a tabela Internship Offers
    public function internshipOffers()
    {
        return $this->hasMany(InternshipOffer::class, 'plan_id');
    }
}
