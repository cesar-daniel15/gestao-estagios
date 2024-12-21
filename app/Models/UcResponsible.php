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

    /**
     * Relacionamento com o modelo User.
     * Cada responsável da UC pertence a um único usuário.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'user_id'); // Relacionamento com o usuário responsável
    }

    /**
     * Relacionamento com a tabela Institution.
     * Cada responsável da UC pertence a uma instituição.
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id'); // Relacionamento com a instituição
    }

    /**
     * Relacionamento com a tabela UC_to_Responsibles.
     * Um responsável pode estar associado a várias unidades curriculares (Ucs).
     */
    public function ucs()
    {
        return $this->belongsToMany(UnitCurricular::class, 'uc_to_responsibles', 'uc_responsible_id', 'uc_id'); 
    }

    /**
     * Relacionamento com a tabela Notifications.
     * Um responsável pode ter várias notificações.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'uc_responsible');
    }
}
