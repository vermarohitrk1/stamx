<?php

use Illuminate\Database\Seeder;
use App\Timezone;

/**
 * Class TimezoneSeeder
 */
class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = time();

        foreach (timezone_identifiers_list() as $zone) {
            $allZones = [];
            $allZones['timezone'] = $zone;
            Timezone::create($allZones);
        }
    }
}
