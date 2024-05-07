<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\Student;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CourseSeeder::class,
            UserSeeder::class,
            StudentSeeder::class,
            ActivitySeeder::class,
        ]);
    }
}
