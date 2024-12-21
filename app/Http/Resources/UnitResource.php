<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UnitResource extends JsonResource
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
            'acronym' => $this->acronym,
            'ects' => $this->ects,
            'course' => [
                'id' => $this->course->id ?? 'Não existe', 
                'name' => $this->course->name ?? 'Não existe',
                'acronym' => $this->course->acronym ?? 'Não existe', 
                'institution_id' => $this->course->institution_id ?? 'Não existe',
                'institution' => [
                    'id' => $this->course->institution->id ?? 'Não existe',
                    'acronym' => $this->course->institution->acronym ?? 'Não existe',
                ],
            ],
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
        ];
    }
}
