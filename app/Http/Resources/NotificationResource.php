<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Importar o Carbon para manipulação de datas

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $student = $this->student; // Relacionamento com o estudante
        $user = $student && $student->user ? $student->user : null; // Relacionamento do estudante com o usuário

        return [
            'id' => $this->id,
            'title' => $this->title ?? 'Título não disponível',
            'message' => $this->message ?? 'Mensagem não disponível',
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),

            'student' => $student ? [
                'id' => $student->id ?? 'Não disponível',
                'name' => $student->name ?? 'Nome não disponível',
                'user' => $user ? [
                    'name' => $user->name ?? 'Nome do usuário não disponível',
                ] : null,
            ] : null, // Fechamento do array 'student'
        ];
    }
}

