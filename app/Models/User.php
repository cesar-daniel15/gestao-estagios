<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // Nome da tabela
    protected $table = 'users';
    
    // Campos
    protected $fillable = [
        'name',
        'profile',
        'email',
        'password',
        'id_institution',
        'id_company',
        'id_responsible',
        'id_student',
        'token',
        'account_is_verified',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'account_is_verified' => 'boolean',
            'last_login' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relacao com as Institutions
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'id_institution'); 
    }

    // Relacao com as Companies
    public function company()
    {
        return $this->belongsTo(Company::class, 'id_company');
    }

    // Relacao com os Responsaveis
    public function responsible()
    {
        return $this->belongsTo(UCResponsible::class, 'id_responsible');
    }

    // Relacao com os Students
    public function student()
    {
        return $this->belongsTo(Student::class, 'id_student');
    }
}
