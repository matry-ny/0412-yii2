<?php

namespace app\modules\chat\controllers;

use app\modules\chat\assets\ChatAsset;
use yii\web\Controller;

/**
 * Class GroupController
 * @package app\modules\chat\controllers
 */
class GroupController extends Controller
{
    public function actionIndex()
    {
        $this->getView()->registerAssetBundle(ChatAsset::class);

        return $this->render('index');
    }
}
