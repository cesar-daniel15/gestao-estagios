<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Institution extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'institutions';
    
    // Campos
    protected $fillable = [
        'acronym',
        'phone',
        'address',
        'logo',
        'website',
    ];

    
    // Relacao com a tabela Users
    public function users()
    {
        return $this->hasMany(User::class, 'id_institution');
    }
}
