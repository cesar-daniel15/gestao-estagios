<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'internship_offer_id' => $this->internship_offer_id,
            'internship_offer_title' => $this->internshipOffer->title, 
            'date' => $this->date,
            'morning_start_time' => $this->morning_start_time ? \Carbon\Carbon::parse($this->morning_start_time)->format('H:i') : null,
            'morning_end_time' => $this->morning_end_time ? \Carbon\Carbon::parse($this->morning_end_time)->format('H:i') : null,
            'afternoon_start_time' => $this->afternoon_start_time ? \Carbon\Carbon::parse($this->afternoon_start_time)->format('H:i') : null,
            'afternoon_end_time' => $this->afternoon_end_time ? \Carbon\Carbon::parse($this->afternoon_end_time)->format('H:i') : null,
            'approval_hours' => $this->approval_hours,
            'summary' => $this->summary,
            'approval_status' => $this->approval_status === 'pending' ? 'Pendente' : ($this->approval_status === 'approved' ? 'Aprovado' : 'Rejeitado'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}