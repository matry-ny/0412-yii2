<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authors}}`.
 */
class m190219_185846_create_authors_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%authors}}');
    }
}
