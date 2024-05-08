<?php

namespace Database\Factories;

use App\Enum\UserRole;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $student = User::factory(['role_id' => UserRole::STUDENT->value])->create();

        return [
            'address' => fake()->address(),
            'grade' => fake()->numberBetween(1, 100),
            'user_id' => $student->id,
            'course_id' => fake()->randomElement(Course::pluck('id')),
        ];
    }
}
