<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Importar o Carbon para manipulação de datas

class InstitutionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->users->first();

        return [
            'user' => [
                'id' => $user->id ?? 'N/A', 
                'name' => $user->name ?? 'Utilizador não disponível', 
                'email' => $user->email ?? 'Email não disponível', 
                'account_is_verified' => $user->account_is_verified ?? false, 
            ],
            'id' => $this->id,
            'acronym' => $this->acronym,
            'phone' => $this->phone ?? 'Não disponível', 
            'address' => $this->address ?? 'Não disponível', 
            'website' => $this->website ?? 'Não disponível', 
            'logo' => $this->logo ? asset('storage/' . $this->logo) : asset('images/uploads/default-user.png'),
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
        ];
    }
}