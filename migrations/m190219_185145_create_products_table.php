<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m190219_185145_create_products_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'price' => $this->decimal(2),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%products}}');
    }
}
