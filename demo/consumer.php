<?php

declare(strict_types=1);

require_once "vendor/autoload.php";

$queueName = 'stream.txt';
if(!file_exists($queueName)) {
    touch($queueName);
}
$queue = fopen($queueName, 'rb');

while(true) {
    $rawMessage = fread($queue, 2000);
    if (!empty($rawMessage)) {
        $event = new \Instapro\Events\Service_request\V1\JobPublished();
        $event->mergeFromString($rawMessage);

        echo $event->getTitle() . PHP_EOL;
    }
    usleep(10);
}
