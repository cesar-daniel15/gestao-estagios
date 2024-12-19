<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'courses';

    // Campos
    protected $fillable = [
        'institution_id',
        'name',
        'acronym',
    ];

    // Relacionamento com tabela Institution
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    // Relacao para tabela Internship Offers
    public function internshipOffers()
    {
        return $this->hasMany(InternshipOffer::class, 'course_id'); 
    }

    // Relacao com Units Curriculars
    public function unitsCurriculars()
    {
        return $this->hasMany(UnitCurricular::class, 'course_id');
    }
}
