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
            'name' => $this->name,
            'duration' => $this->duration,
            'description' => $this->description ?? 'Não disponível', 
            'start_date' => Carbon::parse($this->start_date)->format('d/m/Y'), // Formatar a data
            'end_date' => Carbon::parse($this->end_date)->format('d/m/Y'), // Formatar a data
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(), // Mostrar data de criação
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(), // Mostrar data de atualização
        ];
    }
}
