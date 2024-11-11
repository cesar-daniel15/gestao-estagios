<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Importar o Carbon para manipulação de datas
use App\Models\Institution; // Para verificar a tabela institution


class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        if ($this->id && Institution::find($this->id)) { // Se tiver este id na tabela
            $profile = 'Instituição';
        } else {
            $profile = 'Outro';
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'profile' => $profile,
            'email' => $this->email,
            'account_is_verified' => $this->account_is_verified ? 'Sim' : 'Não',  // Retorna "Sim" ou "Não" dependendo do estado de verificação
            'last_login' => $this->last_login ? Carbon::parse($this->last_login)->locale('pt')->diffForHumans() : 'Nunca',
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
        ];
    }
}
