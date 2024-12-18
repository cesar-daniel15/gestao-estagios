<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
