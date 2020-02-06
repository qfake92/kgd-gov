<?php namespace app\forms\parser;

use common\components\api\GovKz;
use common\models\Arrear;
use common\models\ArrearType;
use common\models\Debtor;
use common\models\TaxDepartment;
use Exception;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class InnRequestForm extends Model
{
	public $inn;
	public $save = false;
	public $result;

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			['inn', 'required'],
			['inn', 'match', 'pattern' => '/^\d{12}$/', 'message' => 'Введите корректный ИНН'],
			['save', 'filter', 'filter' => 'boolval'],
		];
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return ['inn' => 'ИНН'];
	}

	/**
	 * @param array $data
	 * @return bool
	 * @throws \Throwable
	 */
	public function fetchData($data)
	{
		if (!$this->load($data) || !$this->validate()) {
			return false;
		}

		if (($result = $this->getInfo()) === false) {
			return false;
		}

		$txn = Yii::$app->db->beginTransaction();
		try {
			$this->parseResult($result);
			$txn->commit();
		} catch (Exception $e) {
			$txn->rollBack();
			$this->addError('inn', $e->getMessage());
			return false;
		}

		if ($this->save === true) {
			Yii::$app->session->setFlash('success', 'Данные сохранены');
		}
		$this->save = true;

		return true;
	}

	/**
	 * @return bool|mixed
	 */
	public function getInfo()
	{
		try {
			return Yii::$app->cache->getOrSet($this->getCacheKey(), function () {
				return GovKz::searchTaxArrear($this->inn);
			}, 600);
		} catch (Exception $e) {
			$this->addError('inn', $e->getMessage());

			return false;
		}
	}

	/**
	 * @return string
	 */
	private function getCacheKey()
	{
		return sprintf('%s-%s', self::class, $this->inn);
	}

	/**
	 * @param array $data
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 */
	private function parseResult($data)
	{
		$debtor = Debtor::fromRawData($data);
		if ($this->save) {
			if (!$debtor->isNewRecord) {
				$debtor->delete();
			}
			if (!$debtor->save()) {
				throw new Exception('Не удалось сохранить данные');
			}
		}

		$debts = [];
		foreach (ArrayHelper::getValue($data, 'taxOrgInfo', []) as $organization) {
			$taxDepartment = TaxDepartment::fromRawData($organization);
			if ($this->save && !$taxDepartment->save()) {
				throw new Exception('Не удалось сохранить данные');
			}

			foreach (ArrayHelper::getValue($organization, 'taxPayerInfo', []) as $debtsRaw) {
				foreach (ArrayHelper::getValue($debtsRaw, 'bccArrearsInfo', []) as $debtInfo) {
					$debt = $this->parseDebtInfo($debtor->id, $taxDepartment->id, $debtInfo);
					$debt->populateRelation('department', $taxDepartment);
					$debt->populateRelation('debtor', $debtor);
					$debts[] = $debt;
				}
			}
		}

		$debtor->populateRelation('arrears', $debts);
		$this->result = $debtor;
	}

	/**
	 * @param int|null $debtorId
	 * @param int|null $departmentId
	 * @param array    $data
	 * @return Arrear
	 * @throws Exception
	 */
	private function parseDebtInfo($debtorId, $departmentId, $data)
	{
		$debtType = ArrearType::fromRawData($data);
		if ($this->save && !$debtType->save()) {
			throw new Exception('Не удалось сохранить данные');
		}

		$debt = new Arrear([
			'debtor_id'     => $debtorId,
			'department_id' => $departmentId,
			'type_id'       => $debtType->id,
			'tax'           => ArrayHelper::getValue($data, 'taxArrear'),
			'poena'         => ArrayHelper::getValue($data, 'poenaArrear'),
			'percent'       => ArrayHelper::getValue($data, 'percentArrear'),
			'fine'          => ArrayHelper::getValue($data, 'fineArrear'),
			'total'         => ArrayHelper::getValue($data, 'totalArrear'),
		]);
		if ($this->save && !$debt->save()) {
			throw new Exception('Не удалось сохранить данные');
		}

		$debt->populateRelation('type', $debtType);

		return $debt;
	}
}