<?php

declare(strict_types=1);

use Instapro\Events\Jobs\V1\JobPublished;
use Instapro\Events\Jobs\V1\JobPublished\Importance;
use Instapro\Types\V1\Attachment;

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

$queue = fopen('stream.txt', 'wb');
while (true) {
    $event = createRandomEvent();

    echo $event->getTitle() . PHP_EOL;
    fwrite($queue, $event->serializeToString());

    sleep(1);
}
