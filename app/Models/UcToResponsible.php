<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UcToResponsible extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'uc_to_responsibles';

    // Campos
    protected $fillable = [
        'uc_responsible_id',
        'uc_id',
    ];

    // Relacionamento com o modelo UCResponsible
    public function ucResponsible()
    {
        return $this->belongsTo(UcResponsible::class, 'uc_responsible_id');
    }

    // Relacionamento com o modelo UnitCurricular
    public function unitCurricular()
    {
        return $this->belongsTo(UnitCurricular::class, 'uc_id');
    }
}
