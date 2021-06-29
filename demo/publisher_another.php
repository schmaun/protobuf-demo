<?php

declare(strict_types=1);

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once "vendor/autoload.php";

function createRandomEvent(): object
{

}

function setupRabbitMq(): \PhpAmqpLib\Channel\AMQPChannel
{
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();
    $channel->queue_declare('events', false, false, false, false);

    return $channel;
}

$channel = setupRabbitMq();
while (true) {
    $event = createRandomEvent();

    $msg = new AMQPMessage($event->serializeToString(), ["application_headers" => ["x-type" => ["S", $event::class]]]);
    $channel->basic_publish($msg, '', 'events');

    echo 'Published message'. PHP_EOL;

    sleep(1);
}
