<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tax_department}}`.
 */
class m200204_180438_create_tax_department_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%tax_department}}', [
			'id'              => $this->primaryKey(),
			'department_code' => $this->integer()->notNull()->unique(),
			'name'            => $this->string(2048)->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%tax_department}}');
	}
}
