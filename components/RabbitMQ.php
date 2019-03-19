<?php

namespace app\components;

use AMQPConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use yii\base\Component;

/**
 * Class RabbitMQ
 * @package app\components
 */
class RabbitMQ extends Component
{
    /**
     * @var string
     */
    public $server = '127.0.0.1';

    /**
     * @var int
     */
    public $port = 5672;

    /**
     * @var string
     */
    public $vHost = '/';

    /**
     * @var string
     */
    public $login = 'guest';

    /**
     * @var string
     */
    public $password = 'guest';

    /**
     * @var AMQPStreamConnection|null
     */
    private $connection;

    /**
     * @return AMQPStreamConnection
     */
    public function getConnection(): AMQPStreamConnection
    {
        if ($this->connection === null) {
            $this->connection = new AMQPStreamConnection(
                $this->server,
                $this->port,
                $this->login,
                $this->password
            );
        }

        return $this->connection;
    }
}
