<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m190912_101714_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string(6)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'rotten_at' => $this->integer(),
            'status' => $this->integer(1)->defaultValue(1),
            'size' => $this->integer()->defaultValue(100)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
    }
}
