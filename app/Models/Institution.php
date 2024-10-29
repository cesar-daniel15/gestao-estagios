<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Institution extends Model
{
    // Defenicao dos atributos da tabela 
    protected $fillable = [
        'name',
        'acronym',
        'email',
        'password',
        'phone',
        'address',
        'logo',
        'website',
        'token',
        'account_is_verified',
        'last_login',
    ];

    // Define os atributos que serao ocultos
    protected $hidden = [
        'password',
        'token',
    ];

     // Atribui a password com hash 
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}