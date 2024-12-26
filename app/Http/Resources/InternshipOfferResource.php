<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Importar o Carbon para manipulação de datas

class InternshipOfferResource extends JsonResource
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
            'company' => [
                'id' => $this->company->id ?? null,
                'name' => $this->company->name ?? 'Empresa não disponível',
            ],
            'institution' => [
                'id' => $this->institution->id ?? null,
                'name' => $this->institution->name ?? 'Instituição não disponível',
            ],
            'course' => [
                'id' => $this->course->id ?? null,
                'name' => $this->course->name ?? 'Curso não disponível',
            ],
            'title' => $this->title,
            'description' => $this->description ?? 'Descrição não disponível',
            'deadline' => $this->deadline ? Carbon::parse($this->deadline)->locale('pt')->isoFormat('LL') : 'Sem prazo definido',
            'plan' => [
                'id' => $this->plan->id ?? null,
                'title' => $this->plan->title ?? 'Plano não disponível',
            ],
            'final_report' => [
                'id' => $this->finalReport->id ?? null,
                'title' => $this->finalReport->title ?? 'Relatório final não disponível',
            ],
            'status' => $this->status === 'active' ? 'Ativo' : 'Inativo',
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
        ];
    }
}
