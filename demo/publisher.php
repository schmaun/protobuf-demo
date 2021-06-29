<?php

declare(strict_types=1);

use Instapro\Events\Jobs\V1\JobPublished;
use Instapro\Events\Jobs\V1\JobPublished\Importance;
use Instapro\Types\V1\Attachment;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once "vendor/autoload.php";

function getRandomId(): int
{
    return random_int(1, 20);
}

function getRandomTitle(): string
{
    $strings = [
        'Plumbing',
        'Fix house',
        'Renovate Bathroom',
    ];

    return $strings[array_rand($strings)];
}

function getRandomCoordinates(): float
{
    return (float)(random_int(1, 50) / 7);
}

function createRandomEvent(): JobPublished
{
    $event = new JobPublished();
    $event->setJobId(getRandomId());
    $event->setConsumerId(getRandomId());
    $event->setServiceId(getRandomId());
    $event->setTitle(getRandomTitle());

    $event->setImportance(Importance::IMPORTANCE_ASAP_UNSPECIFIED);

    $coordinates = new \Instapro\Types\V1\Coordinates();
    $coordinates->setLatitude(getRandomCoordinates());
    $coordinates->setLongitude(getRandomCoordinates());
    $event->setCoordinates($coordinates);

    $event->setImages([
                          'one' => new Attachment(),
                          'two' => new Attachment(),
                      ]);

    $event->setFiles([
                         new Attachment(),
                         new Attachment(),
                     ]);
    return $event;
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

    echo $event->getTitle() . PHP_EOL;

    sleep(1);
}
