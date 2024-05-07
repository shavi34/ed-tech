<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Models\Student;
use App\Models\User;

class CoursePolicy
{
    /**
     * Create a new policy instance.
     */
    public function list(User $user)
    {
        return $user->role_id === UserRole::TEACHER->value;
    }
}
