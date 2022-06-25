<?php

namespace App\Gamify\Points;

use Ansezz\Gamify\BasePoint;

class PointCreated extends BasePoint
{

    /**
     * check if user achieve the point
     * @param $point
     * @param $subject
     *
     * @return bool
     */
    public function __invoke($point, $subject)
    {
        return true;
    }

    public function getPointable(){
        return $this->hasMany(Pointable::Class);
    }

}
