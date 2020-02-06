<?php namespace common\components\api;

use Yii;

class HttpTransport
{
	const METHOD_GET = 'get';
	const METHOD_POST = 'post';

	const ENCODE_RAW = 'raw';
	const ENCODE_JSON = 'json';

	/**
	 * @param string     $endpoint
	 * @param string     $method
	 * @param array|null $data
	 * @param string     $encoding
	 * @return mixed
	 * @throws \Exception
	 */
	public static function request($endpoint, $method = self::METHOD_GET, $data = null, $encoding = self::ENCODE_RAW)
	{
		Yii::info($endpoint, self::class);
		$ch = curl_init($endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if ($method === self::METHOD_POST) {
			curl_setopt_array($ch, [
				CURLOPT_POST       => true,
				CURLOPT_HTTPHEADER => [self::getContentType($encoding)],
				CURLOPT_POSTFIELDS => self::encodeData($encoding, $data),
			]);
		}

		$response = curl_exec($ch);
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
			Yii::error(curl_getinfo($ch), self::class);
			throw new \Exception('Сервис временно недоступен. Попробуйте позже');
		}

		return self::decodeData($encoding, $response);
	}

	/**
	 * @param string $endpoint
	 * @return mixed
	 * @throws \Exception
	 */
	public static function get($endpoint)
	{
		return self::request($endpoint);
	}

	/**
	 * @param string $endpoint
	 * @return mixed
	 * @throws \Exception
	 */
	public static function getJson($endpoint)
	{
		return self::request($endpoint, self::METHOD_GET, null, self::ENCODE_JSON);
	}

	/**
	 * @param string $endpoint
	 * @param array  $data
	 * @return mixed
	 * @throws \Exception
	 */
	public static function post($endpoint, $data = [])
	{
		return self::request($endpoint, self::METHOD_POST, $data);
	}

	/**
	 * @param string $endpoint
	 * @param array  $data
	 * @return mixed
	 * @throws \Exception
	 */
	public static function postJson($endpoint, $data = [])
	{
		return self::request($endpoint, self::METHOD_POST, $data, self::ENCODE_JSON);
	}

	/**
	 * @param string $encoding
	 * @return string
	 */
	private static function getContentType($encoding)
	{
		switch ($encoding) {
			case self::ENCODE_RAW:
				return 'Content-Type: application/x-www-form-urlencoded';
			case self::ENCODE_JSON:
				return 'Content-Type: application/json';
			default:
				return 'Content-Type: text/plain';
		}
	}

	/**
	 * @param string $encoding
	 * @param mixed  $data
	 * @return mixed
	 */
	private static function encodeData($encoding, $data)
	{
		switch ($encoding) {
			case self::ENCODE_RAW:
				return http_build_query($data);
			case self::ENCODE_JSON:
				return json_encode($data);
			default:
				return $data;
		}
	}

	/**
	 * @param string $encoding
	 * @param string $data
	 * @return mixed
	 */
	private static function decodeData($encoding, $data)
	{
		switch ($encoding) {
			case self::ENCODE_JSON:
				return json_decode($data, true);
			default:
				return $data;
		}
	}

}