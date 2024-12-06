<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitCurricular extends Model
{
    use HasFactory;

    protected $table = 'units_curriculars';

    // Definição dos atributos da tabela
    protected $fillable = [
        'name',
        'acronym',
        'ects',
        'course-id'
    ];

    /**
     * Relacionamento com a tabela Courses.
     * Uma unidade curricular pertence a um curso.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
