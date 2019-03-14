<?php

namespace app\modules\chat\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class ChatAsset
 * @package app\modules\chat\assets
 */
class ChatAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/chat/public';

    /**
     * @var array
     */
    public $js = [
        'js/autobahn.js',
        'js/chat.js'
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class
    ];

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => true
    ];
}
