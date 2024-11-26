<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon; // Importar o Carbon para manipulação de datas
use App\Models\Institution; // Para verificar a tabela institution


class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        // Traduz o perfil
        $profileTranslations = [
            'Institution' => 'Instituição',
            'Company' => 'Empresa',
            'Responsible' => 'Coordenador da Unidade Curricular',
            'Student' => 'Aluno',
            'Admin' => 'Administrador',
        ];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'profile' => $profileTranslations[$this->profile] ?? $this->profile,
            'email' => $this->email,

            'id_institution' => $this->institution ? [
                'id' => $this->institution->id,
                'acronym' => $this->institution->acronym, 
                'phone' => $this->institution->phone, 
                'address' => $this->institution->address, 
                'logo' => $this->institution->logo, 
                'website' => $this->institution->website, 
            ] : null,

            'id_company' => $this->company ? [
                'id' => $this->company->id,
                'phone' => $this->company->phone,
                'industry' => $this->company->industry, 
                'brief_description' => $this->company->brief_description, 
                'address' => $this->company->address, 
                'foundation_date' => $this->company->foundation_date, 
                'logo' => $this->company->logo, 
            ] : null,

            'id_responsible' => $this->responsible ? [
                'id' => $this->responsible->id,
                'phone' => $this->responsible->phone,
                'picture' => $this->responsible->picture, 
            ] : null,

            'id_student' => $this->student ? [
                'id' => $this->student->id,
                'assigned_internship_id' => $this->student->assigned_internship_id,
                'phone' => $this->student->phone,
                'picture' => $this->student->picture,
            ] : null,

            'token' => $this->token,
            'account_is_verified' => $this->account_is_verified ? 'Sim' : 'Não',
            'last_login' => $this->last_login ? Carbon::parse($this->last_login)->locale('pt')->diffForHumans() : 'Nunca',
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
        ];
    }
}
