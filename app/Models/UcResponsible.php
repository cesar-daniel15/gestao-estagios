<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UcResponsible extends Model
{
    protected $table = 'uc_responsibles';
    
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
