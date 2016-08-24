<?php
return [
    'createPost' => [
        'type' => 2,
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'createPost',
        ],
    ],
];
