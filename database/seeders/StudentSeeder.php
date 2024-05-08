<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'student@test.com')->exists()) {
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
        Student::factory(10)->create();
    }
}
