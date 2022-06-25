<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PerMinuteAutoresponders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'perminute:Autoresponders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this will send emails in every minute';

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
          $today = date("Y-m-d"); 
		$time=date('H:i');
        $compaigns= \App\Autoresponders::where("status","Active")->where("typeOnChoice","Singleday")->where("date",$today)->where("time",$time)->get();
     
        if (!empty($compaigns) && count($compaigns) > 0) {
             foreach ($compaigns as $row){
                    \App\Autoresponders::sendCompaignEmailsMessage($row);
             }
         }
		$users =\App\User::where('is_active', '0')->get();
			foreach( $users as $inactive){
				$currentDate=date('Y-m-d H:i');
				$DateFiveMinutes= strtotime($inactive->created_at .' + 5 minute');
				$deletedDate= date('Y-m-d H:i', $DateFiveMinutes);
				if($deletedDate == $currentDate){
					$users = User::where('id', $inactive->id)->delete();
				}
			}
        $this->info('Compaigns are initiated');
    }
}
