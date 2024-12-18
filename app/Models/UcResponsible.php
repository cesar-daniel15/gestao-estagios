<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UcResponsible extends Model
{
    // Nome da tabela
    protected $table = 'uc_responsibles';
    
    // Campos
    protected $fillable = [
        'phone',
        'picture',
    ];

    // Relacao com a tabela Users
    public function users()
    {
        return $this->hasMany(User::class, 'id_responsible');
    }
}
