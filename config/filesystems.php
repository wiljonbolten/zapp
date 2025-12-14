<?php

return [
    'default' => 'local',
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => getcwd(),
        ],
        'mount' => [
            'driver' => 'local',
            'root' => getcwd() . '/mount',
        ],
    ],
];
