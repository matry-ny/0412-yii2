<?php

use yii\db\Migration;

/**
 * Class m190219_190206_add_product_author_column
 */
class m190219_190206_add_product_author_column extends Migration
{
    public function safeUp()
    {
        $this->addColumn(
            '{{%products}}',
            'author_id',
            $this->integer()->after('price')
        );
        $this->addForeignKey(
            'fk-products-author_id-authors-id',
            '{{%products}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-products-author_id-authors-id',
            '{{%products}}'
        );
        $this->dropColumn('{{%products}}', 'author_id');
    }
}
