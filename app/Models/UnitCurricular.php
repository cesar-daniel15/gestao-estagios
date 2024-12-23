<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitCurricular extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'units_curriculars';

    // Campos
    protected $fillable = [
        'course_id',
        'name',
        'acronym',
        'ects',
    ];

    // Relacao coma  a tabela Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id'); 
    }

    // Relacao coma  a tabela UctoStudents
    public function students()
    {
        return $this->belongsToMany(Student::class, 'uc_to_students', 'uc_id', 'student_id'); 
    }

    // Relacao com a tabela UCtoResponsibles
    public function responsibles()
    {
        return $this->belongsToMany(UcResponsible::class, 'uc_to_responsibles', 'uc_id', 'uc_responsible_id');
    }

}