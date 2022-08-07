<?php

require __DIR__ . '/../vendor/autoload.php';

use Dzion\MessageQueue\MessageQueueService;

$redis = new MessageQueueService();

echo 'Ok';

while (true){
    $tweetCount = $redis->getCountMessages();
    if ($tweetCount) {
        $path = __DIR__ . '/';
        $command = "php {$path}consumer.php > /dev/null 2>&1 &";
        system($command, $retval);
    }
    sleep(1);
}
