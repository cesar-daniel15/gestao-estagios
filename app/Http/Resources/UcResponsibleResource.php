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
        // Verifica se existe um responsável (user) associado ao responsável da UC
        $user = $this->user; // Acessando o relacionamento 'user'

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
        ];
    }
}
