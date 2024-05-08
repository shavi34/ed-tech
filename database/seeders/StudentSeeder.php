<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! User::where('email', 'student@test.com')->exists()) {
            $student = User::factory(
                [
                    'name' => 'Test Student',
                    'email' => 'student@test.com',
                    'role_id' => UserRole::STUDENT,
                ]
            )->create();
            Student::factory([
                'user_id' => $student->id,
            ])->create();
        }
        Student::factory(5)->create();

        $classes = User::where('email', 'teacher@test.com')->first()->classes;

        foreach ($classes as $class) {
            Student::factory(['course_id' => $class->id])->count(rand(10, 15))->create();
        }
    }
}
