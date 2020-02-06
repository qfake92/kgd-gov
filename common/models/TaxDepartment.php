<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%tax_department}}".
 *
 * @property int    $id
 * @property int    $department_code
 * @property string $name
 */
class TaxDepartment extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%tax_department}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['department_code', 'name'], 'required'],
			[['department_code'], 'default', 'value' => null],
			[['department_code'], 'integer'],
			[['name'], 'string', 'max' => 2048],
			[['department_code'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id'              => 'ID',
			'department_code' => 'Department Code',
			'name'            => 'Name',
		];
	}

	/**
	 * @param array $data
	 * @return TaxDepartment
	 */
	public static function fromRawData($data)
	{
		$code = ArrayHelper::getValue($data, 'charCode');
		$model = self::findOne(['department_code' => $code]);
		if ($model === null) {
			$model = new self([
				'department_code' => $code,
				'name'            => ArrayHelper::getValue($data, 'nameRu'),
			]);
		}

		return $model;
	}
}
