<?php

use Illuminate\Database\Seeder;
use App\Hiringstage;

class HiringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['name'=> 'New', 'status' => 'Enable', 'is_deletable' => 0];
        Hiringstage::create($data);
    }
}
