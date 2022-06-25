<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Supportticket;
class SupportTicketsClosed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticketsServiceRequest:autoclosed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Support Tickets Auto Closed & handle service requests after 14 days';

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
        $job= redirect()->route('support.autoclose');
           $this->info('Support tickets are auto closed & service requests are closed successfully');
    }
}
