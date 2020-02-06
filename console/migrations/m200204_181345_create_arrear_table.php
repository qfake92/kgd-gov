<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%arrear}}`.
 */
class m200204_181345_create_arrear_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%arrear}}', [
			'id'            => $this->primaryKey(),
			'debtor_id'     => $this->integer()->notNull(),
			'department_id' => $this->integer()->notNull(),
			'type_id'       => $this->integer()->notNull(),
			'tax'           => $this->money(18, 2)->notNull()->defaultValue(0),
			'poena'         => $this->money(18, 2)->notNull()->defaultValue(0),
			'percent'       => $this->money(18, 2)->notNull()->defaultValue(0),
			'fine'          => $this->money(18, 2)->notNull()->defaultValue(0),
			'total'         => $this->money(18, 2)->notNull()->defaultValue(0),
		]);

		$this->addForeignKey('arrear_debtor_id_fkey', '{{%arrear}}', 'debtor_id', '{{%debtors}}', 'id', 'CASCADE');
		$this->addForeignKey('arrear_department_id_fkey', '{{%arrear}}', 'department_id', '{{%tax_department}}', 'id', 'CASCADE');
		$this->addForeignKey('arrear_type_id_fkey', '{{%arrear}}', 'type_id', '{{%arrear_type}}', 'id', 'CASCADE');
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%arrear}}');
	}
}
