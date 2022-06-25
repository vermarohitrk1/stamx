<?php

namespace App\Gamify\Badges;

use Ansezz\Gamify\BaseBadge;

class PointCreated extends BaseBadge
{

    /**
     *  beginner check
     * @param $badge
     * @param $subject
     *
     * @return bool
     */

    public function levelOne($badge, $subject)
    {

        $point = \Ansezz\Gamify\Badge::where('level',1)->first();
        return $subject->achieved_points >= ($point->points ?? 0);
    }
    public function levelTwo($badge, $subject)
    {
        $point = \Ansezz\Gamify\Badge::where('level',2)->first();
        return $subject->achieved_points >= ($point->points ?? 0);
    }
    public function levelThree($badge, $subject)
    {
        $point = \Ansezz\Gamify\Badge::where('level',3)->first();
        return $subject->achieved_points >= ($point->points ?? 0);
    }
    public function levelFour($badge, $subject)
    {
        $point = \Ansezz\Gamify\Badge::where('level',4)->first();
        return $subject->achieved_points >=  ($point->points ?? 0);
    }
    public function levelFive($badge, $subject)
    {
        $point = \Ansezz\Gamify\Badge::where('level',5)->first();
        return $subject->achieved_points >= ($point->points ?? 0);
    }
    public function levelSix($badge, $subject)
    {
        $point = \Ansezz\Gamify\Badge::where('level',6)->first();
        return $subject->achieved_points >= ($point->points ?? 0);
    }
    public function levelSeven($badge, $subject)
    {
        $point = \Ansezz\Gamify\Badge::where('level',7)->first();
        return $subject->achieved_points >= ($point->points ?? 0);
    }
    public function levelEight($badge, $subject)
    {
        $point = \Ansezz\Gamify\Badge::where('level',8)->first();
        return $subject->achieved_points >=  ($point->points ?? 0);
    }
    public function levelNine($badge, $subject)
    {
        $point = \Ansezz\Gamify\Badge::where('level',9)->first();
        return $subject->achieved_points >= ($point->points ?? 0);
    }
    public function levelTen($badge, $subject)
    {
        $point = \Ansezz\Gamify\Badge::where('level',10)->first();
        return $subject->achieved_points >= ($point->points ?? 0);
    }

}
