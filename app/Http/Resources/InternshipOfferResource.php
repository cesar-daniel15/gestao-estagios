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
        $companyUser   = $this->company && $this->company->users ? $this->company->users->first() : null; 
        $studentUser   = $this->student && $this->student->users ? $this->student->users->first() : null; 

    
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline ? Carbon::parse($this->deadline)->format('Y-m-d') : null,
            'status' => $this->status === 'open' ? 'Aberto' : ($this->status === 'closed' ? 'Fechado' : 'Arquivado'),
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
            'company' => [
                'id' => $this->company->id ?? null,
                'users' => [
                    'name' => $companyUser->name ?? 'Utilizador não disponível', 
                    'email' => $companyUser->email ?? 'Email não disponível', 
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
                'id' => $this->plans->first()->id ?? null, 
                'start_date' => $this->plans->first()->start_date ?? null,
                'end_date' => $this->plans->first()->end_date ?? null,
                'objectives' => $this->plans->first()->objectives ?? null,
                'status' => $this->plans->isNotEmpty() ? ($this->plans->first()->status === 'pending' ? 'Pendente' : ($this->plans->first()->status === 'approved' ? 'Aprovado' : 'Rejeitado')) : 'Sem Status',
            ],
            'final_report' => [
                'id' => $this->finalReport->id ?? null,
                'title' => $this->finalReport->title ?? 'Relatório final não disponível',
            ],
            'student' => [
                'id' => $student->id ?? null,
                'users' => [
                    'name' => $studentUser  ? $studentUser ->name : 'Aluno não disponível',
                ],
            ],
        ];
    }
}