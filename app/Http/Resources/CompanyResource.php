<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Importar o Carbon para manipulação de datas

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->users->first();

        // return parent::toArray($request);
        return [
            'user' => [
                'name' => $user->name ?? 'Utilizador não disponível', 
                'email' => $user->email ?? 'Email não disponível', 
                'account_is_verified' => $user->account_is_verified ?? false, 
            ],
            'id' => $this->id,
            'phone' => $this->phone,
            'logo' => $this->logo ? asset('storage/' . $this->logo) : asset('images/uploads/default-user.png'),
            'industry' => $this->industry,
            'brief_description' => $this->brief_description ?? 'N/A',
            'address' => $this->address,
            'foundation_date' => $this->foundation_date ? Carbon::parse($this->foundation_date)->format('Y-m-d') : null,
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
        ];
    }
}
