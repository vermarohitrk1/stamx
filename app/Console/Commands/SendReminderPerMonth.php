<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use  App\SMS;

class SendReminderPerMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendreminder:month';

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
        $sms->sendRemindersPerMonth();
        $this->info('Success! Check your messages.');
    }
}
