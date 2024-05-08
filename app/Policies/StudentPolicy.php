<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
  /**
   * Create a new policy instance.
   */

  public function show(User $user, Student $student)
  {
    return ($user->role_id === UserRole::TEACHER->value) ||
        ($user->role_id === UserRole::STUDENT->value && $student->user_id === $user->id);
  }
}
