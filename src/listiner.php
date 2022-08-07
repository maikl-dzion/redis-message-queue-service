<?php

require __DIR__ . '/../vendor/autoload.php';

use Dzion\MessageQueue\MessageQueueService;

$redis = new MessageQueueService();

while (true){
    $tweetCount = $redis->getCountMessages();
    if (!$tweetCount) {
        sleep(1);
    } else {
        $command = "php consumer.php";
        system($command, $retval);
    }
}
