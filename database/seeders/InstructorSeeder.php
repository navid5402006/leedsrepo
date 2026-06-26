<?php
// database/seeders/InstructorSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Instructor;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = [
            ['name' => 'Dr. Ahmed Khan', 'email' => 'ahmed@leeds.edu', 'phone' => '0300-1234567', 'specialization' => 'Web Development', 'status' => 'active'],
            ['name' => 'Ms. Fatima Ali', 'email' => 'fatima@leeds.edu', 'phone' => '0300-1234568', 'specialization' => 'Graphic Design', 'status' => 'active'],
            ['name' => 'Mr. Usman Raza', 'email' => 'usman@leeds.edu', 'phone' => '0300-1234569', 'specialization' => 'MS Office', 'status' => 'active'],
            ['name' => 'Ms. Sara Khan', 'email' => 'sara@leeds.edu', 'phone' => '0300-1234570', 'specialization' => 'SEO', 'status' => 'active'],
            ['name' => 'Dr. Bilal Ahmed', 'email' => 'bilal@leeds.edu', 'phone' => '0300-1234571', 'specialization' => 'Data Science', 'status' => 'active'],
            ['name' => 'Ms. Zara Hassan', 'email' => 'zara@leeds.edu', 'phone' => '0300-1234572', 'specialization' => 'UI/UX Design', 'status' => 'active'],
        ];

        foreach ($instructors as $instructor) {
            Instructor::create($instructor);
        }
    }
}