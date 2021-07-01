<?php

declare(strict_types=1);

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once "vendor/autoload.php";

function setupRabbitMq(): \PhpAmqpLib\Channel\AMQPChannel
{
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();
    $channel->queue_declare('events', false, false, false, false);

    return $channel;
}

$channel = setupRabbitMq();

function getMessageContent(object $event): string
{
    switch ($event::class) {
        case \Instapro\Events\Jobs\V1\JobPublished::class:
            return $event->getTitle();
        case \Instapro\Events\Talks\V1\FeedbackProvided::class:
            return $event->getContent();
        default:
            return 'ignored message type';
    }
}

while (true) {
    $channel->basic_consume('events', '', false, true, false, false, function (AMQPMessage $msg) {
        $properties = $msg->get('application_headers');
        $type = $properties['x-type'];

        $event = new $type();
        $event->mergeFromString($msg->getBody());

        echo get_class($event) . ': ' . getMessageContent($event) . PHP_EOL;
    });

    while ($channel->is_open()) {
        $channel->wait();
    }
}
