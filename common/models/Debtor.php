<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%debtors}}".
 *
 * @property int         $id
 * @property int         $inn
 * @property string      $date
 * @property string|null $name
 * @property Arrear[]    $arrears
 */
class Debtor extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%debtors}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['inn'], 'required'],
			[['inn'], 'default', 'value' => null],
			[['inn'], 'match', 'pattern' => '/^\d{12}$/'],
			[['date'], 'safe'],
			[['name'], 'string', 'max' => 255],
			[['inn'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id'   => 'ID',
			'inn'  => 'ИНН',
			'date' => 'Дата',
			'name' => 'Имя',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getArrears()
	{
		return $this->hasMany(Arrear::class, ['debtor_id' => 'id']);
	}

	/**
	 * @param array $data
	 * @return Debtor
	 */
	public static function fromRawData($data)
	{
		$inn = ArrayHelper::getValue($data, 'iinBin');
		$model = self::findOne(['inn' => $inn]);
		if ($model === null) {
			$model = new self([
				'inn'  => $inn,
				'name' => ArrayHelper::getValue($data, 'nameRu'),
			]);
		}

		return $model;
	}
}
