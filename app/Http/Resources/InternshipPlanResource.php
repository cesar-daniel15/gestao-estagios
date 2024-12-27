<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Importar o Carbon para manipulação de datas

class InternshipPlanResource extends JsonResource
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
            'total_hours' => $this->total_hours ?? 'N/A',
            'start_date' => $this->start_date ? Carbon::parse($this->start_date)->format('d/m/Y') : null,
            'end_date' => $this->end_date ? Carbon::parse($this->end_date)->format('d/m/Y') : null,
            'status' => $this->status ?? 'N/A',
            'approved_by_uc' => $this->approved_by_uc ? 'Sim' : 'Não', // Return 'Sim' or 'Não'
            'objectives' => $this->objectives ?? 'N/A',
            'planned_activities' => $this->planned_activities ?? 'N/A',
        ];
    }
}
