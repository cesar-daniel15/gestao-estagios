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
            // Usar 'optional()' para acessar o curso sem erro se não existir
            'course' => [
                'id' => $this->course->id ?? 'Não existe', // Protege contra o erro
                'name' => $this->course->name ?? 'Não existe', // Protege contra o erro
                'acronym' => $this->course->acronym ?? 'Não existe', // Protege contra o erro
            ],
            'created_at' => Carbon::parse($this->created_at)->locale('pt')->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->locale('pt')->diffForHumans(),
        ];
    }
}
