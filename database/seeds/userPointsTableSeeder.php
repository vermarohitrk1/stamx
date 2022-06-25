<?php

use Illuminate\Database\Seeder;
use App\Point;
class userPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Groups Seeder
        // \Ansezz\Gamify\GamifyGroup::create(['id' => 1,'name' => 'Point','type' => 'point','created_at' => '2021-09-01 12:38:03','updated_at' => '2021-09-01 12:38:03']);

        // Points Seeder 
        \Ansezz\Gamify\Point::create(['id' => 1,'name' => 'login','description' => 'login','point' => 10,'class' => 'App\\Gamify\\Points\\PointCreated','allow_duplicate' => 0,'gamify_group_id' => 1,'created_at' => '2021-09-01 12:38:03','updated_at' => '2021-09-01 12:38:03']);
        \Ansezz\Gamify\Point::create(['id' => 2, 'name' => 'complete_course', 'description' =>  'complete_course', 'point' => 15, 'class' =>  'App\\Gamify\\Points\\PointCreated', 'allow_duplicate' =>  0, 'gamify_group_id' =>  1, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
        \Ansezz\Gamify\Point::create(['id' => 3, 'name' => 'create_pathway', 'description' =>  'create_pathway', 'point' => 20, 'class' =>  'App\\Gamify\\Points\\PointCreated', 'allow_duplicate' =>  0, 'gamify_group_id' =>  1, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
        \Ansezz\Gamify\Point::create(['id' => 4, 'name' => 'book_appointment', 'description' =>  'book_appointment', 'point' => 25, 'class' =>  'App\\Gamify\\Points\\PointCreated', 'allow_duplicate' =>  0, 'gamify_group_id' =>  1, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
        \Ansezz\Gamify\Point::create(['id' => 5, 'name' => 'donate', 'description' =>  'donate', 'point' => 30, 'class' =>  'App\\Gamify\\Points\\PointCreated', 'allow_duplicate' =>  0, 'gamify_group_id' =>  1, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
        \Ansezz\Gamify\Point::create(['id' => 6, 'name' => 'add_review', 'description' =>  'add_review', 'point' => 35, 'class' =>  'App\\Gamify\\Points\\PointCreated', 'allow_duplicate' =>  0, 'gamify_group_id' =>  1, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
        \Ansezz\Gamify\Point::create(['id' => 7, 'name' => 'complete_chore', 'description' =>  'complete_chore', 'point' => 40, 'class' => 'App\\Gamify\\Points\\PointCreated', 'allow_duplicate' => 0,  'gamify_group_id' =>  1, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
        \Ansezz\Gamify\Point::create(['id' => 8, 'name' => 'assessment', 'description' =>  'assessment', 'point' => 45, 'class' =>  'App\\Gamify\\Points\\PointCreated', 'allow_duplicate' => 0,  'gamify_group_id' => 1, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
        \Ansezz\Gamify\Point::create(['id' => 9, 'name' => 'complete_survey', 'description' =>  'complete_survey', 'point' => 50, 'class' =>  'App\\Gamify\\Points\\PointCreated', 'allow_duplicate' => 0,  'gamify_group_id' => 1, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
        \Ansezz\Gamify\Point::create(['id' => 10, 'name' => 'complete_profile', 'description' =>  'complete_profile', 'point' => 55, 'class' =>  'App\\Gamify\\Points\\PointCreated', 'allow_duplicate' => 0,  'gamify_group_id' => 1, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
        
    }
}

