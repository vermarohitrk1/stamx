<?php

return [
    // Reputation model
    'point_model'                  => '\Ansezz\Gamify\Point',

    // Broadcast on private channel
    'broadcast_on_private_channel' => true,

    // Channel name prefix, user id will be suffixed
    'channel_name'                 => 'user.reputation.',

    // Badge model
    'badge_model'                  => '\Ansezz\Gamify\Badge',

    // Where all badges icon stored
    'badge_icon_folder'            => 'images/badges/',

    // Extention of badge icons
    'badge_icon_extension'         => '.svg',

    // All the levels for badge
    'badge_levels'                 => [
        'level_one'    => 1,
        'level_two'    => 2,
        'level_three'  => 3,
        'level_four'   => 4,
        'level_five'   => 5,
        'level_six'    => 6,
        'level_seven'  => 7,
        'level_eight'  => 8,
        'level_nine'   => 9,
        'level_ten'    => 10,
    ],

    // Default level
    'badge_default_level'          => 1,

    // Badge achieved vy default if check function not exit
    'badge_is_archived'            => false,

    // point achieved vy default if check function not exit
    'point_is_archived'            => true,
];
