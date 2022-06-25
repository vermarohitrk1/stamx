<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DailyAutoresponders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:Autoresponders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will send daily auto responders';

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
       $date=date("Y-m-d");
        $compaigns= \App\Autoresponders::where("status","Active")->where("typeOnChoice","Weekly")->get();
     
      if (!empty($compaigns) && count($compaigns) > 0) {
             foreach ($compaigns as $row){
                 $weekDay=json_decode($row->day);
                $todays = date('l', strtotime(date('Y-m-d')));
             
                if(in_array($todays, $weekDay)){        
                
                    \App\Autoresponders::sendCompaignEmailsMessage($row);
                }
                                        
             }
         }
        $this->info('Compaigns are initiated');
    }
}
