<?php

namespace App\Console;

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
        Commands\SendReminderPerMonth::class,
        Commands\SendReminderPerDay::class,
        Commands\SendReminderPerWeek::class,
        Commands\SendReminderMailPerMonth::class,
        Commands\SendReminderMailPerDay::class,
        Commands\SendReminderMailPerWeek::class,
        Commands\SupportTicketsClosed::class,
         Commands\DailyAutoresponders::class,
        Commands\PerMinuteAutoresponders::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('sendreminder:month')->monthly();
        $schedule->command('sendreminder:day')->daily();
        $schedule->command('sendreminder:week')->weekly();
        $schedule->command('sendreminderMail:month')->monthly();
        $schedule->command('sendreminderMail:day')->daily();
        $schedule->command('sendreminderMail:week')->weekly();
         $schedule->command('ticketsServiceRequest:autoclosed')->daily();
          $schedule->command('perminute:Autoresponders')->everyMinute();
           $schedule->command('daily:Autoresponders')->daily();
             $schedule->command('disposable:update')->weekly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
