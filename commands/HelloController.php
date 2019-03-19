<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\components\RabbitMQ;
use PhpAmqpLib\Message\AMQPMessage;
use yii\console\Controller;

/**
 * Class HelloController
 * @package app\commands
 */
class HelloController extends Controller
{
    /**
     * @param int $number
     */
    public function actionSetUpNumber(int $number)
    {
        /** @var RabbitMQ $rabbitMQ */
        $rabbitMQ = \Yii::$app->get('rabbitMQ');
        $channel = $rabbitMQ->getConnection()->channel();
        $channel->queue_declare(
            'numbers',
            false,
            false,
            false,
            false
        );

        $message = new AMQPMessage(
            json_encode(['number' => $number])
        );
        $channel->basic_publish($message, '', 'numbers');

        $channel->close();
        $rabbitMQ->getConnection()->close();
    }

    public function actionRenderNumbers()
    {
        /** @var RabbitMQ $rabbitMQ */
        $rabbitMQ = \Yii::$app->get('rabbitMQ');
        $channel = $rabbitMQ->getConnection()->channel();

        $channel->basic_consume(
            'numbers',
            '',
            false,
            true,
            false,
            false,
            function(AMQPMessage $message) {
                $data = json_decode($message->body, true);
                echo $data['number'] . PHP_EOL;

                sleep(5);
            }
        );

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $rabbitMQ->getConnection()->close();
    }
}
