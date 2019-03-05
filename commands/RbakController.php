<?php

namespace app\commands;

use app\components\rbak\rules\ProductCreatorRule;
use yii\console\Controller;

/**
 * Class RbakController
 * @package app\commands
 */
class RbakController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->getAuthManager();

        $auth->removeAll();

        $guest = $auth->createRole('guest');
        $manager = $auth->createRole('manager');
        $admin = $auth->createRole('admin');

        $auth->add($guest);
        $auth->add($manager);
        $auth->add($admin);

        $productCreatorRule = new ProductCreatorRule();
        $auth->add($productCreatorRule);

        $viewProductsList = $auth->createPermission('viewProductsList');
        $viewProduct = $auth->createPermission('viewProduct');
        $addProduct = $auth->createPermission('addProduct');
        $updateProduct = $auth->createPermission('updateProduct');
        $deleteProduct = $auth->createPermission('deleteProduct');
        $exportProducts = $auth->createPermission('exportProducts');

        $deleteOwnProduct = $auth->createPermission('deleteOwnProduct');
        $deleteOwnProduct->ruleName = $productCreatorRule->name;

        $auth->add($viewProductsList);
        $auth->add($viewProduct);
        $auth->add($addProduct);
        $auth->add($updateProduct);
        $auth->add($deleteProduct);
        $auth->add($exportProducts);
        $auth->add($deleteOwnProduct);

        $auth->addChild($guest, $viewProductsList);
        $auth->addChild($guest, $viewProduct);

        $auth->addChild($manager, $guest);
        $auth->addChild($manager, $addProduct);
        $auth->addChild($manager, $updateProduct);
        $auth->addChild($manager, $deleteOwnProduct);

        $auth->addChild($admin, $manager);
        $auth->addChild($admin, $deleteProduct);
        $auth->addChild($admin, $exportProducts);

        $auth->assign($admin, 1);
        $auth->assign($manager, 2);
    }
}

