<?php

require __DIR__ . '/vendor/autoload.php';

use Dzion\MessageQueue\MessageQueueService;

$redis = new MessageQueueService();

echo "---Start---\n";

while (true){
    $tweetCount = $redis->getCountMessages();
    if ($tweetCount) {
        // $command = "php src/consumer.php > /dev/null 2>&1 &";
        $path = __DIR__ . '/src';
        $command = "php {$path}/consumer.php";
        system($command, $retval);
    }
    sleep(1);
    echo "next...  \n";
}
