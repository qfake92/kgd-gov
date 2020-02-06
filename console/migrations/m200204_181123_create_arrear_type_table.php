<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%arrear_type}}`.
 */
class m200204_181123_create_arrear_type_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%arrear_type}}', [
			'id'   => $this->primaryKey(),
			'code' => $this->integer()->notNull()->unique(),
			'name' => $this->string(2048)->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%arrear_type}}');
	}
}
