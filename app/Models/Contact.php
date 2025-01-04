<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // Nome da tabela
    protected $table = 'contacts';

    // Campos
    protected $fillable = [
        'name',
        'email',
        'profile',
        'message',
    ];
}
