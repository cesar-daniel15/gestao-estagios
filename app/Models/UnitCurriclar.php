<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitsCurricular extends Model
{
    use HasFactory;

    // Definição dos atributos da tabela
    protected $fillable = [
        'name',
        'acronym',
        'ects',
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
