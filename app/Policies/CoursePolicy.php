<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;

class CoursePolicy
{
  /**
   * Create a new policy instance.
   */
  public function list(User $user): bool
  {
    return $user->role_id === UserRole::TEACHER->value;
  }

  public function show(User $user, Course $course): bool
  {
    return $user->role_id === UserRole::TEACHER->value && $course->teachers->contains($user->id);
  }
}
