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
            'morning_start_time' => $this->morning_start_time,
            'morning_end_time' => $this->morning_end_time,
            'afternoon_start_time' => $this->afternoon_start_time,
            'afternoon_end_time' => $this->afternoon_end_time,
            'approval_hours' => $this->approval_hours,
            'summary' => $this->summary,
            'approval_status' => $this->approval_status === 'pending' ? 'Pendente' : ($this->approval_status === 'approved' ? 'Aprovado' : 'Rejeitado'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}