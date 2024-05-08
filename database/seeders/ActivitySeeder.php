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

        Student::whereIn('course_id', $teacherClasses)->get()
            ->each(fn ($student) => $student->activities()
                ->createMany(
                    Activity::factory()->count(rand(2, 10))->make()->toArray()
                ));
    }
}
