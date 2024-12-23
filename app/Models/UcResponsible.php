<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UcResponsible extends Model
{
    use HasFactory;

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

    // Relacao com a tabela UCS
    public function ucs()
    {
        return $this->belongsToMany(UnitCurricular::class, 'uc_to_responsibles', 'uc_responsible_id', 'uc_id'); 
    }

    // Relacao com a tabela Notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'uc_responsible');
    }
}
