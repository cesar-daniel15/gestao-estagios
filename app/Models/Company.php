<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'companies';

    // Campos
    protected $fillable = [
        'phone',
        'logo',
        'industry',
        'brief_description',
        'address',
        'foundation_date',
    ];

    // Relacao com a tabela Users
    public function users()
    {
        return $this->hasMany(User::class, 'id_company');
    }

    // Relacao para tabela Internship Offers
    public function internshipOffers()
    {
        return $this->hasMany(InternshipOffer::class, 'company_id'); 
    }
}
