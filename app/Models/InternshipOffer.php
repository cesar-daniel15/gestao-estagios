<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternshipOffer extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'internship_offers';

    // Campos
    protected $fillable = [
        'company_id',
        'institution_id',
        'course_id',
        'title',
        'description',
        'deadline',
        'status',
    ];

    // Relacao com a tabela Company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Relacao com a tabela Institution
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    // Relacao com a tabela Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // Relacao com a  tabela Internship Plans
    public function plans()
    {
        return $this->hasMany(InternshipPlan::class, 'internship_offer_id'); 
    }

    // Relacao com a tabela Final Reports
    public function finalReports()
    {
        return $this->hasMany(FinalReport::class, 'internship_offer_id'); 
    }

    // Relacao com a tabela Students
    public function student()
    {
        return $this->hasOne(Student::class, 'assigned_internship_id');
    }

    // Relacao com a tabela Attendance Record
    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class, 'internship_offer_id');
    }
}
