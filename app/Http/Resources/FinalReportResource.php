<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Para manipulação de datas

class FinalReportResource extends JsonResource
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
            'internship_offer_id' => $this->internship_offer_id ?? 'Não disponível', 
            'total_hours' => $this->total_hours ?? 'Não disponível',
            'total_days' => $this->total_days ?? 'Não disponível',
            'company_evaluation' => $this->company_evaluation ?? 'Não disponível',
            'final_evaluation' => $this->final_evaluation ?? 'Não disponível',
            'status' => $this->status === 'submitted' ? 'Submetido' : ($this->status === 'evaluated' ? 'Avaliado' : 'Rejeitado'),
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
            'internship_offer_title' => $this->internshipOffer->title ?? 'Não disponível', // Acessa o título da oferta de estágio
        ];
    }
}
