<?php
return [
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
        'db'     => [
	        'class'          => 'yii\db\Connection',
	        'dsn'            => 'pgsql:host=127.0.0.1;dbname=postgres',
	        'username'       => 'postgres',
	        'password'       => '',
	        'charset'        => 'utf8',
	        'emulatePrepare' => true,
        ],
    ],
];
