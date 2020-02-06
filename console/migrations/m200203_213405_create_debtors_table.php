<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%debtors}}`.
 */
class m200203_213405_create_debtors_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%debtors}}', [
			'id'   => $this->primaryKey(),
			'inn'  => $this->bigInteger()->notNull()->unique(),
			'date' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
			'name' => $this->string()->defaultValue(null),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%debtors}}');
	}
}
