<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use  App\EMAIL;
class SendReminderMailPerDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendreminderMail:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $mail=new EMAIL();
        $mail->sendRemindersPerDay();
       // $this->info('Success! Check your messages.');
    }
}
