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

        $user = $this->users->first();

        return [
            'user' => [
                'id' => $user->id ?? 'N/A',
                'name' => $user->name ?? 'Utilizador não disponível',
                'email' => $user->email ?? 'Email não disponível',
                'account_is_verified' => $user->account_is_verified ?? false,
            ],
            'id' => $this->id,
            'phone' => $this->phone,
            'pending_internship_offer_id' => $this->pending_internship_offer_id,
            'picture' => $this->picture ? asset('storage/' . $this->picture) : asset('images/uploads/default-user.png'),
            'assigned_internship_id' => $this->assigned_internship_id ?? 'Sem Estágio',
                'internship_offer' => [
                        'title' => $this->internshipOffer->title ?? 'Sem Estágio',
                    ],
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
            'ucs' => $this->ucs->map(function ($uc) {
                return [
                    'student_num' => $uc->pivot->uc_responsible_id ?? 'Não disponível', 
                    'uc_id' => $uc->id ?? 'Não disponível', 
                    'lective_year' => $uc->pivot->lective_year ?? 'Não disponível', 
                    'uc_name' => $uc->name ?? 'Não disponível', 
                    'course' => [
                        'id' => $uc->course->id ?? 'Não disponível',
                        'name' => $uc->course->name ?? 'Não disponível',
                        'acronym' => $uc->course->acronym ?? 'Não disponível',
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