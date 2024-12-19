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
    
    // Relacionamento Coma tabela UC_to_Responsibles
    public function ucs()
    {
        return $this->belongsToMany(UnitCurricular::class, 'uc_to_responsibles', 'uc_responsible_id', 'uc_id'); 
    }

    // Relacionamento com a tabela Notifications 
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'uc_responsible');
    }
}
