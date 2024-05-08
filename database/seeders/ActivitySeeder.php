<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::factory(30)->create();

        $teacherClasses = User::where('email', 'teacher@test.com')->first()->classes->pluck('id');

        $user = User::where('email', 'student@test.com')->first();
        if ($user->student) {
            Activity::factory(['student_id' => $user->student->id])->count(rand(2, 10))->create();
        }

        Student::whereIn('course_id', $teacherClasses)->get()
            ->each(fn ($student) => $student->activities()
                ->createMany(
                    Activity::factory()->count(rand(2, 10))->make()->toArray()
                ));
    }
}
