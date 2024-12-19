<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'notifications';

    // Campos
    protected $fillable = [
        'uc_responsible',
        'student_num',
        'title',
        'content',
        'status_visualization',
    ];

    // Relacao com a tabela Stundent
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_num', 'id'); 
    }

    // Relacao com a tabela UCResponsible
    public function ucResponsible()
    {
        return $this->belongsTo(UCResponsible::class, 'uc_responsible', 'id'); 
    }

}
