<?php

use Illuminate\Database\Seeder;

class userBadgeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Groups Seeder
        //  \Ansezz\Gamify\GamifyGroup::create(['id' => 2,'name' => 'Badge','type' => 'badge','created_at' => '2021-09-01 12:38:03','updated_at' => '2021-09-01 12:38:03']);

         // Points Seeder 
         DB::table('badges')->insert(['id' => 1, 'name' => 'level 1', 'description' =>  'level_one', 'image' => NULL, 'class' => 'App\\Gamify\\Badges\\PointCreated', 'level' => 1, 'gamify_group_id' => 2, 'created_at' => '2021-09-01 12:38:03', 'updated_at' => '2021-09-01 12:38:03']);
         DB::table('badges')->insert(['id' => 2, 'name' => 'level 2', 'description' =>  'level_two', 'image' => NULL, 'class' =>  'App\\Gamify\\Badges\\PointCreated', 'level' =>  2, 'gamify_group_id' =>  2, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
         DB::table('badges')->insert(['id' => 3, 'name' => 'level 3', 'description' =>  'level_three', 'image' => NULL, 'class' =>  'App\\Gamify\\Badges\\PointCreated', 'level' =>  3, 'gamify_group_id' =>  2, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
         DB::table('badges')->insert(['id' => 4, 'name' => 'level 4', 'description' =>  'level_four', 'image' => NULL, 'class' =>  'App\\Gamify\\Badges\\PointCreated', 'level' =>  4, 'gamify_group_id' =>  2, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
         DB::table('badges')->insert(['id' => 5, 'name' => 'level 5', 'description' =>  'level_five', 'image' => NULL, 'class' =>  'App\\Gamify\\Badges\\PointCreated', 'level' =>  5, 'gamify_group_id' =>  2, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
         DB::table('badges')->insert(['id' => 6, 'name' => 'level 6', 'description' =>  'level_six', 'image' => NULL, 'class' =>  'App\\Gamify\\Badges\\PointCreated', 'level' =>  6, 'gamify_group_id' =>  2, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
         DB::table('badges')->insert(['id' => 7, 'name' => 'level 7', 'description' =>  'level_seven', 'image' => NULL, 'class' => 'App\\Gamify\\Badges\\PointCreated', 'level' => 7,  'gamify_group_id' =>  2, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
         DB::table('badges')->insert(['id' => 8, 'name' => 'level 8', 'description' =>  'level_eight', 'image' => NULL, 'class' =>  'App\\Gamify\\Badges\\PointCreated', 'level' => 8,  'gamify_group_id' => 2, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
         DB::table('badges')->insert(['id' => 9, 'name' => 'level 9', 'description' =>  'level_nine', 'image' => NULL, 'class' =>  'App\\Gamify\\Badges\\PointCreated', 'level' => 9,  'gamify_group_id' => 2, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
         DB::table('badges')->insert(['id' => 10, 'name' => 'level 10', 'description' =>  'level_ten', 'image' => NULL, 'class' =>  'App\\Gamify\\Badges\\PointCreated', 'level' => 10,  'gamify_group_id' => 2, 'created_at' => '2021-09-01 07:08:03', 'updated_at' => '2021-09-01 07:08:03']);
        
    }
}
