<?php

use App\Hiringstage;
use Illuminate\Database\Seeder;

class DisqualifyStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['name'=> Hiringstage::DISQUALIFIED_LABEL, 'status' => 'Enable', 'is_deletable' => 0];
        Hiringstage::create($data);
    }
}
