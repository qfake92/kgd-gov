<?php namespace common\components\api;

use Exception;
use Yii;
use yii\helpers\ArrayHelper;

class Anticaptcha
{
	const ENDPOINT_CREATE_TASK = 'https://api.anti-captcha.com/createTask';
	const ENDPOINT_GET_TASK_RESULT = 'https://api.anti-captcha.com/getTaskResult';

	const RETRY_TIMEOUT = 10;
	const RETRY_COUNT = 9;

	/**
	 * @param string $img
	 * @return string
	 * @throws Exception
	 */
	public static function solve($img)
	{
		$task = HttpTransport::postJson(self::ENDPOINT_CREATE_TASK, [
			'clientKey' => Yii::$app->params['anticaptchaKey'],
			'task'      => [
				'type'      => 'ImageToTextTask',
				'body'      => base64_encode($img),
				'phrase'    => false,
				'case'      => true,
				'numeric'   => 0,
				'math'      => false,
				'minLength' => 0,
				'maxLength' => 0
			]
		]);

		$resultParams = [
			'clientKey' => Yii::$app->params['anticaptchaKey'],
			'taskId'    => $task['taskId']
		];

		$try = 0;
		do {
			sleep(self::RETRY_TIMEOUT);
			$captchaData = HttpTransport::postJson(self::ENDPOINT_GET_TASK_RESULT, $resultParams);
			$captchaText = ArrayHelper::getValue($captchaData, ['solution', 'text']);
		} while ($captchaText === null && $try++ < self::RETRY_COUNT);

		if ($captchaText === null) {
			throw new Exception('Капча не пройдена, попробуйте позже');
		}

		return $captchaText;
	}

}