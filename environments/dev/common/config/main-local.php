<?php
return [
	'components' => [
		'mailer' => [
			'class'            => 'yii\swiftmailer\Mailer',
			'viewPath'         => '@common/mail',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => true,
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
