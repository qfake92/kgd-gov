<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%arrear_type}}".
 *
 * @property int      $id
 * @property int      $code
 * @property string   $name
 *
 * @property Arrear[] $arrears
 */
class ArrearType extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%arrear_type}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['code', 'name'], 'required'],
			[['code'], 'default', 'value' => null],
			[['code'], 'integer'],
			[['name'], 'string', 'max' => 2048],
			[['code'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id'   => 'ID',
			'code' => 'Code',
			'name' => 'Name',
		];
	}

	/**
	 * Gets query for [[Arrears]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getArrears()
	{
		return $this->hasMany(Arrear::className(), ['type_id' => 'id']);
	}

	/**
	 * @param array $data
	 * @return ArrearType
	 */
	public static function fromRawData($data)
	{
		$bcc = ArrayHelper::getValue($data, 'bcc');
		$model = self::findOne(['code' => $bcc]);
		if ($model === null) {
			$model = new self([
				'code' => $bcc,
				'name' => ArrayHelper::getValue($data, 'bccNameRu'),
			]);
		}

		return $model;
	}
}
