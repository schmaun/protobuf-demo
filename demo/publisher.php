<?php

declare(strict_types=1);

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

function createRandomEvent(): \Instapro\Events\Service_request\V1\JobPublished
{
    $event = new \Instapro\Events\Service_request\V1\JobPublished();
    $event->setJobId(getRandomId());
    $event->setConsumerId(getRandomId());
    $event->setServiceId(getRandomId());
    $event->setTitle(getRandomTitle());

    $event->setImportance(\Instapro\Events\Service_request\V1\JobPublished\Importance::ASAP);

    $coordinates = new \Instapro\Types\V1\Coordinates();
    $coordinates->setLatitude(getRandomCoordinates());
    $coordinates->setLongitude(getRandomCoordinates());
    $event->setCoordinates($coordinates);

    $event->setImages([
                          'one' => new \Instapro\Types\V1\Attachment(),
                          'two' => new \Instapro\Types\V1\Attachment(),
                      ]);

    $event->setFiles([
                         new \Instapro\Types\V1\Attachment(),
                         new \Instapro\Types\V1\Attachment(),
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
