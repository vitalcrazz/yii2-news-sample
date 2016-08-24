<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'assignmentFile' => '@common/rbac/assignments.php',
            'itemFile' => '@common/rbac/items.php',
        ],
    ],
];
