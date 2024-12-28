<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AttendanceRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id ?? null,
                'name' => $this->user->name ?? 'Utilizador não disponível',
                'email' => $this->user->email ?? 'Email não disponível',
            ],
            'date' => $this->date ? Carbon::parse($this->date)->format('d/m/Y') : 'Data não disponível',
            'internship_offer' => [
                'id' => $this->internshipOffer->id ?? null,
                'title' => $this->internshipOffer->title ?? 'Oferta não disponível',
            ],
            'morning_start_time' => $this->morning_start_time ? Carbon::parse($this->morning_start_time)->format('H:i') : 'Não disponível',
            'morning_end_time' => $this->morning_end_time ? Carbon::parse($this->morning_end_time)->format('H:i') : 'Não disponível',
            'afternoon_start_time' => $this->afternoon_start_time ? Carbon::parse($this->afternoon_start_time)->format('H:i') : 'Não disponível',
            'afternoon_end_time' => $this->afternoon_end_time ? Carbon::parse($this->afternoon_end_time)->format('H:i') : 'Não disponível',
            'approval_hours' => $this->approval_hours ?? 'Não disponível',
            'summary' => $this->summary ?? 'Não disponível',
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
        ];
    }
}