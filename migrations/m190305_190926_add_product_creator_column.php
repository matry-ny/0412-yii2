<?php

use yii\db\Migration;

/**
 * Class m190305_190926_add_product_creator_column
 */
class m190305_190926_add_product_creator_column extends Migration
{
    private const AUTHOR_KEY = 'fk-products-created_by-users-id';

    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'created_by', $this->integer());
        $this->addForeignKey(
            self::AUTHOR_KEY,
            '{{%products}}',
            'created_by',
            '{{%users}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(self::AUTHOR_KEY, '{{%products}}');
        $this->dropColumn('{{%products}}', 'created_by');
    }
}
