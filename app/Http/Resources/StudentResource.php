<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
            'address' => $this->address,
            'grade' => $this->grade,
            'name' => $this->name,
            'activity_count' => $this->activities()->count(),
            'class_name' => $this->course->name,
            'activities' => ActivityResource::collection($this->activities),
        ];
    }
}
