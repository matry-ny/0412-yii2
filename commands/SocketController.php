<?php

namespace app\commands;

use app\modules\chat\components\EventPusher;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\Wamp\WampServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\Server;
use React\ZMQ\Context;
use yii\console\Controller;
use ZMQ;

/**
 * Class SocketController
 * @package app\commands
 */
class SocketController extends Controller
{
    public function actionListener($tcpPort = 5555, $webPort = 8888)
    {
        $loop = Factory::create();

        $pusher = new EventPusher();

        $context = new Context($loop);
        $pull = $context->getSocket(ZMQ::SOCKET_PULL);
        $pull->bind("tcp://127.0.0.1:{$tcpPort}");
        $pull->on('message', [$pusher, 'onPushEventData']);

        $webSocket = new Server(
            "127.0.0.1:{$webPort}",
            $loop
        );
        $webServer = new IoServer(
            new HttpServer(
                new WsServer(
                    new WampServer($pusher)
                )
            ),
            $webSocket
        );

        $loop->run();
    }
}
