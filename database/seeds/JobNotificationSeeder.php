<?php

use App\JobNotification;
use Illuminate\Database\Seeder;

class JobNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobNotification = new JobNotification();
        $notificationData = [
            [
                'event_name' => 'Candidate disqualified',
                'event_slug' => 'candidate_disqualified',
            ],
            [
                'event_name' => 'Event created',
                'event_slug' => 'event_created',
            ],
            [
                'event_name' => 'Note created',
                'event_slug' => 'note_created',
            ],
            [
                'event_name' => 'Job Applied',
                'event_slug' => 'job_applied',
            ],
            [
                'event_name' => 'Job apply response for candidate',
                'event_slug' => 'job_apply_response_for_candidate',
            ],
        ];

        foreach ($notificationData as $data){
            $jobNotification->create($data);
        }
    }
}
