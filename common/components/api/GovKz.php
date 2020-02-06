<?php namespace common\components\api;

class GovKz
{
	const ENDPOINT_CAPTCHA = 'http://kgd.gov.kz/apps/services/CaptchaWeb/generate?uid=%s&t=%s';
	const ENDPOINT_SEARCH_TAX_ARREAR = 'http://kgd.gov.kz/apps/services/culs-taxarrear-search-web/rest/search';

	/**
	 * @param int $inn
	 * @return mixed
	 * @throws \Exception
	 */
	public static function searchTaxArrear($inn)
	{
		$captchaUid = self::generateUid();
		$img = HttpTransport::get(sprintf(self::ENDPOINT_CAPTCHA, $captchaUid, self::generateUid()));
		$captcha = Anticaptcha::solve($img);

		$data = HttpTransport::postJson(self::ENDPOINT_SEARCH_TAX_ARREAR, [
			'iinBin'             => $inn,
			'captcha-user-value' => $captcha,
			'captcha-id'         => $captchaUid
		]);

		return $data;
	}

	/**
	 * @return string
	 */
	private static function generateUid()
	{
		return strtolower(sprintf(
			'%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(16384, 20479),
			mt_rand(32768, 49151),
			mt_rand(0, 65535),
			mt_rand(0, 65535),
			mt_rand(0, 65535)
		));
	}
}