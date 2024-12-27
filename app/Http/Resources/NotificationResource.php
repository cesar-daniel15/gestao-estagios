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
        $student = $this->student; 
        $uc_responsible = $this->ucResponsible; 

        return [
            'id' => $this->id,
            'title' => $this->title ?? 'Título não disponível',
            'content' => $this->content ?? 'Mensagem não disponível',
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
            'status_visualization' => $this->status_visualization ?? 'Não disponível',
            'student' => $student ? [
                'id' => $student->id ?? 'Não disponível',
                'user' => [
                    'name' => $student->users->first()->name ?? 'Utilizador não disponível', 
                    'email' => $student->users->first()->email ?? 'Email não disponível', 
                ],
                'institution' => [
                    'acronym' => $student->ucs->first() && $student->ucs->first()->course && $student->ucs->first()->course->institution 
                        ? $student->ucs->first()->course->institution->acronym 
                        : 'Instituição não disponível',
                ],
            ] : null, 
            'uc_responsible' => $uc_responsible ? [
                'id' => $uc_responsible->id ?? 'Não disponível',
                'user' => [
                    'name' => $uc_responsible->users->first()->name ?? 'Utilizador não disponível', 
                    'email' => $uc_responsible->users->first()->email ?? 'Email não disponível', 
                ],
                'institution' => [
                    'acronym' => $uc_responsible->ucs->first() && $uc_responsible->ucs->first()->course && $uc_responsible->ucs->first()->course->institution 
                        ? $uc_responsible->ucs->first()->course->institution->acronym 
                        : 'Instituição não disponível',
                ],
            ] : null,
        ];
    }
}