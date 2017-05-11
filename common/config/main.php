<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'model' => [
                    'class' => 'common\generator\model\Generator',
                    'templates' => ['hero99' => '@common/generator/model/hero99']
                ]
            ]
        ]
    ],
];
