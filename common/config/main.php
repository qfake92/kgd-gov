<?php return [
	'aliases'    => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
	],
	'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'db'    => [
			'class'          => 'yii\db\Connection',
			'dsn'            => 'pgsql:host=127.0.0.1;dbname=postgres',
			'username'       => 'postgres',
			'password'       => '',
			'charset'        => 'utf8',
			'emulatePrepare' => true,
		],
	],
];
