<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Importar o Carbon para manipulação de datas

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // return parent::toArray($request);

        return [
            'user' => [
                'id' => $this->id,
                'name' => $user->name ?? 'Utilizador não disponível', 
                'email' => $user->email ?? 'Email não disponível', 
                'account_is_verified' => $user->account_is_verified ?? false, 
            ],
            'id' => $this->id,
            'phone' => $this->phone,
            'picture' => $this->picture ? asset('storage/' . $this->picture) : asset('images/uploads/default-user.png'),
            'assigned_internship_id' => $this->assigned_internship_id, 
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
        ];
    }
}