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
        $user = $this->company && $this->company->users ? $this->company->users->first() : null; 
    
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline ? Carbon::parse($this->deadline)->locale('pt')->isoFormat('LL') : 'Sem prazo definido',
            'plan_id' => $this->plan_id ?? 'Indisponível',
            'final_report_id' => $this->final_report_id ?? 'Indisponível',
            'status' => $this->status === 'open' ? 'Aberto' : ($this->status === 'closed' ? 'Fechado' : 'Arquivado'),
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
            'company' => [
                'id' => $this->company->id ?? null,
                'users' => [
                    'name' => $user->name ?? 'Utilizador não disponível', 
                    'email' => $user->email ?? 'Email não disponível', 
                    'account_is_verified' => $user->account_is_verified ?? false, 
                ],
            ],
            'institution' => [
                'id' => $this->institution->id ?? null,
                'acronym' => $this->institution->acronym ?? 'Instituição não disponível',
            ],
            'course' => [
                'id' => $this->course->id ?? null,
                'name' => $this->course->name ?? 'Curso não disponível',
            ],
            'plan' => [
                'id' => $this->plan->id ?? null,
                'start_date' => $this->plan->start_date ?? null,
                'end_date' => $this->plan->end_date ?? null,
                'objectives' => $this->plan->objectives ?? null,
            ],
            'final_report' => [
                'id' => $this->finalReport->id ?? null,
                'title' => $this->finalReport->title ?? 'Relatório final não disponível',
            ],
        ];
    }
}