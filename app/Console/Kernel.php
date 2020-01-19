<?php

namespace App\Console;

// use App\Console\Commands\UpdateCourseStudents;

use App\Console\Commands\IncompleteTransactions;
use App\Console\Commands\UpdateSubscriptions;
use App\Console\Commands\UpdateCourseStudents;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdateCourseStudents::class,
        UpdateSubscriptions::class,
        IncompleteTransactions::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('course:updateStudents')
            ->hourly();
        $schedule->command('subscription:update')
            ->hourly();
        $schedule->command('clear: iTransactions')
            ->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
