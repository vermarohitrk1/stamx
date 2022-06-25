<?php

namespace App\Console\Commands;
use  App\SMS;
use Illuminate\Console\Command;

class SendReminderPerDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendreminder:day';

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
        $sms=new SMS();
        $sms->sendRemindersPerDay();
       // $this->info('Success! Check your messages.');
    }
}
