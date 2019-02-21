<?php

namespace app\modules\api\controllers;

use yii\rest\Controller;
use app\models\Product;

/**
 * Class ProductsController
 * @package app\modules\api\controllers
 */
class ProductsController extends Controller
{
    public function actionGetList()
    {
        return Product::find()->all();
    }
}
