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
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'acronym' => $this->acronym,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'logo' => $this->logo,
            'website' => $this->website,
            'account_is_verified' => $this->account_is_verified ? 'Sim' : 'Não',  // Retorna "Sim" ou "Não" dependendo do estado de verificação
            // Formata as datas com o Carbon
            'last_login' => $this->last_login ? Carbon::parse($this->last_login)->locale('pt')->diffForHumans() : 'Nunca',
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
        ];
    }
}
