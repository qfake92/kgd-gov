<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%arrear}}".
 *
 * @property int           $id
 * @property int           $debtor_id
 * @property int           $department_id
 * @property int           $type_id
 * @property float         $tax
 * @property float         $poena
 * @property float         $percent
 * @property float         $fine
 * @property float         $total
 *
 * @property ArrearType    $type
 * @property Debtor        $debtor
 * @property TaxDepartment $department
 */
class Arrear extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%arrear}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['debtor_id', 'department_id', 'type_id'], 'required'],
			[['debtor_id', 'department_id', 'type_id'], 'default', 'value' => null],
			[['debtor_id', 'department_id', 'type_id'], 'integer'],
			[['tax', 'poena', 'percent', 'fine', 'total'], 'number'],
			[['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArrearType::className(), 'targetAttribute' => ['type_id' => 'id']],
			[['debtor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Debtor::className(), 'targetAttribute' => ['debtor_id' => 'id']],
			[['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaxDepartment::className(), 'targetAttribute' => ['department_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id'            => 'ID',
			'debtor_id'     => 'Debtor ID',
			'department_id' => 'Department ID',
			'type_id'       => 'Type ID',
			'tax'           => 'Tax',
			'poena'         => 'Poena',
			'percent'       => 'Percent',
			'fine'          => 'Fine',
			'total'         => 'Total',
		];
	}

	/**
	 * Gets query for [[Type]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getType()
	{
		return $this->hasOne(ArrearType::className(), ['id' => 'type_id']);
	}

	/**
	 * Gets query for [[Debtor]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getDebtor()
	{
		return $this->hasOne(Debtor::className(), ['id' => 'debtor_id']);
	}

	/**
	 * Gets query for [[Department]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getDepartment()
	{
		return $this->hasOne(TaxDepartment::className(), ['id' => 'department_id']);
	}
}
