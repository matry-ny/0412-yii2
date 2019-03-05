<?php

namespace app\components\rbak\rules;

use app\models\Product;
use yii\rbac\Item;
use yii\rbac\Rule;

/**
 * Class ProductCreatorRule
 * @package app\components\rbak\rules
 */
class ProductCreatorRule extends Rule
{
    public $name = 'productCreator';

    /**
     * @param int|string $user
     * @param Item $item
     * @param array $params
     * @return bool
     */
    public function execute($user, $item, $params)
    {
        if (!isset($params['product'])) {
            return false;
        }

        /** @var Product $product */
        $product = $params['product'];

        return $product->created_by === $user;
    }
}
