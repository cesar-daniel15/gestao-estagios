<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceRecord extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'attendance_records';
    
    // Campos
    protected $fillable = [
        'internship_offer_id',
        'date',
        'morning_start_time',
        'morning_end_time',
        'afternoon_start_time',
        'afternoon_end_time',
        'approval_hours',
        'sumary',
    ];

    // Relacao com a tabela Internship Offers
    public function internshipOffer()
    {
        return $this->belongsTo(InternshipOffer::class, 'internship_offer_id');
    }
}
