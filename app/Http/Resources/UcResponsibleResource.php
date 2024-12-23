<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Importar o Carbon para manipulação de datas

class UcResponsibleResource extends JsonResource
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
            'phone' => $this->phone ?? 'Não disponível',
            'picture' => $this->picture ? asset('storage/' . $this->picture) : asset('images/uploads/default-user.png'),
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
            'ucs' => $this->ucs->map(function ($uc) {
                return [
                    'uc_responsible_id' => $uc->pivot->uc_responsible_id ?? 'Não disponível', 
                    'uc_id' => $uc->id ?? 'Não disponível', 
                    'uc_name' => $uc->name ?? 'Não disponível', 
                    'course' => [
                        'id' => $uc->course->id ?? 'Não disponível',
                        'name' => $uc->course->name ?? 'Não disponível',
                        'institution' => [
                            'id' => $uc->course->institution->id ?? 'Não disponível',
                            'acronym' => $uc->course->institution->acronym ?? 'Não disponível',
                            'users' => [
                                'id' => $uc->course->institution->users->first()->id ?? 'Não disponível', 
                                'name' => $uc->course->institution->users->first()->name ?? 'Utilizador não disponível',
                            ],
                        ],
                    ],
                ];
            }),
        ];
    }
}