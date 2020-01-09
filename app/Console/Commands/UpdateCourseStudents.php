<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\StudentsCourse;
use Illuminate\Console\Command;

class UpdateCourseStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:updateStudents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the number course enrolled students';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $courses = Course::whereStatus(1)->get();
        foreach ($courses as $course) {
            $studentCourses = StudentsCourse::whereCourseId($course->id)->whereStatus(1)->get();
            $sum = count($studentCourses);
            $course->total_student = $sum;
            $course->save();

            $total_earned = StudentsCourse::whereCourseId($course->id)->whereStatus(1)->sum('amount');
            $course->total_earned = $total_earned;
            $course->save();
        }

        $this->info('Course Updated');
    }
}
