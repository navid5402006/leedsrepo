<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates sample courses for the academy.
     */
    public function run(): void
    {
        $courses = [
            [
                'name' => 'Web Development',
                'duration' => '3 Months',
                'original_fee' => 30000,
                'description' => 'Comprehensive web development course covering HTML, CSS, JavaScript, React, and Node.js. Build real-world projects and master full-stack development.',
                'status' => 'active'
            ],
            [
                'name' => 'Graphic Design',
                'duration' => '2 Months',
                'original_fee' => 20000,
                'description' => 'Learn professional graphic design using Adobe Photoshop, Illustrator, and InDesign. Master typography, color theory, and visual communication.',
                'status' => 'active'
            ],
            [
                'name' => 'MS Office',
                'duration' => '1.5 Months',
                'original_fee' => 15000,
                'description' => 'Master Microsoft Office applications including Word, Excel, PowerPoint, and Outlook. Prepare for professional office environments.',
                'status' => 'inactive'
            ],
            [
                'name' => 'SEO',
                'duration' => '2 Months',
                'original_fee' => 18000,
                'description' => 'Learn Search Engine Optimization techniques including keyword research, on-page SEO, link building, and analytics. Become an SEO specialist.',
                'status' => 'active'
            ],
            [
                'name' => 'Digital Marketing',
                'duration' => '3 Months',
                'original_fee' => 25000,
                'description' => 'Complete digital marketing course covering social media marketing, email marketing, content marketing, and paid advertising strategies.',
                'status' => 'pending'
            ],
        ];

        foreach ($courses as $course) {
            Course::create([
                'course_code' => Course::generateCourseCode(),
                'name' => $course['name'],
                'duration' => $course['duration'],
                'original_fee' => $course['original_fee'],
                'description' => $course['description'],
                'status' => $course['status'],
            ]);
        }
    }
}