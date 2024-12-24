<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'students';
    
    // Campos
    protected $fillable = [
        'phone',
        'picture',
        'assigned_internship_id', 
    ];

    // Relacao com a tabela Users
    public function users()
    {
        return $this->hasMany(User::class, 'id_student');
    }

    // Relacao com a tabela Assigned Internship
    public function internshipOffer()
    {
        return $this->belongsTo(InternshipOffer::class, 'assigned_internship_id');
    }

    // Relacao com a tabela Notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'student_num'); 
    }

    // Relacao com a tabela uc_to_students
    public function ucs()
    {
        return $this->belongsToMany(UnitCurricular::class, 'uc_to_students', 'student_num', 'uc_id')->withPivot('lective_year'); 
    }

}
