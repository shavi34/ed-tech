<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    $students = $this->students()->orderByDesc('created_at')->limit(10)->get();
    return [
        'id' => $this->id,
        'name' => $this->name,
        'student_count' => $this->students()->count(),
        'students' => StudentResource::collection($students),
    ];
  }
}
