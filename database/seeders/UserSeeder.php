<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function __construct()
    {
        if (Course::count() === 0) {
            Course::factory(5)->create();
        }
    }

    public function run(): void
    {
        User::factory(5)->create()->each(fn ($teacher) => $teacher->classes()->attach($this->getCourses())
        );

        if (! User::where('email', 'teacher@test.com')->exists()) {
            $teacher = User::factory([
                'name' => 'Test Teacher',
                'email' => 'teacher@test.com',
                'role_id' => UserRole::TEACHER,
            ])->create();
            $teacher->classes()->attach($this->getCourses());
        }
    }

    private function getCourses()
    {
        return Course::inRandomOrder()->limit(rand(15, 25))->pluck('id')->toArray();
    }
}
