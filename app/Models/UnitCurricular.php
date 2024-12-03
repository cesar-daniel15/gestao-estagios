<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitCurricular extends Model
{
    use HasFactory;

    protected $table = 'units_curriculars'; // Nome da tabela no banco de dados
    protected $fillable = [
        'course_id',
        'name',
        'acronym',
        'ects',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
