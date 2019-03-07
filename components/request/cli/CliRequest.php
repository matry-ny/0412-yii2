<?php

namespace app\components\request\cli;

/**
 * Class CliRequest
 * @package app\components\request\cli
 */
class CliRequest extends \yii\console\Request
{
    public function getUserIP()
    {
        return '127.0.0.1';
    }
}
