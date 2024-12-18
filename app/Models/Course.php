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

    // Relacionamento com a instituição (Institution).
    // Cada curso pertence a uma instituição
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
