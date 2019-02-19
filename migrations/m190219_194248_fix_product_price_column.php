<?php

use yii\db\Migration;

/**
 * Class m190219_194248_fix_product_price_column
 */
class m190219_194248_fix_product_price_column extends Migration
{
    public function safeUp()
    {
        $this->alterColumn(
            '{{%products}}',
            'price',
            $this->decimal(11, 2)
        );
    }

    public function safeDown()
    {
        $this->alterColumn(
            '{{%products}}',
            'price',
            $this->decimal(2)
        );
    }
}
