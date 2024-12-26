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
            'internship_offer' => [
                'id' => $this->internshipOffer->id ?? null,
                'title' => $this->internshipOffer->title ?? 'Oferta não disponível',
            ],
            'check_in' => $this->check_in ? Carbon::parse($this->check_in)->locale('pt')->isoFormat('LLLL') : 'Não disponível',
            'check_out' => $this->check_out ? Carbon::parse($this->check_out)->locale('pt')->isoFormat('LLLL') : 'Não disponível',
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
        ];
    }
}
