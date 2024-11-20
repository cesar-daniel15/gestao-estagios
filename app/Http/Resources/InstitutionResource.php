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
            'acronym' => $this->acronym,
            'phone' => $this->phone, 
            'address' => $this->address,
            'website' => $this->website, 
            'logo' => $this->logo ? asset('storage/' . $this->logo) : asset('images/uploads/default-user.png'),
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),

            // Carrega os dados do user
            'users' => UserResource::collection($this->whenLoaded('users')), 
        ];
    }
}
