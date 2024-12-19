<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UcToStudent extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'uc_to_students';
    
    // Campos
    protected $fillable = [
        'uc_id',
        'student_num',
        'lective_year',
    ];

    // Relacao com a tabela UnitCurricular
    public function unitCurricular()
    {
        return $this->belongsTo(UnitCurricular::class, 'uc_id', 'id');
    }

    // Relacao com a tabela Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_num', 'id');
    }
}
