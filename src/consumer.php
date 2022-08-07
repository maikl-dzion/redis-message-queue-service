<?php

$dbConfig = require __DIR__ . '/../src/config.php';
require __DIR__ . '/../vendor/autoload.php';

use Dzion\MessageQueue\DbService;
use Dzion\MessageQueue\MessageQueueService;

$pdo   = new DbService($dbConfig);
$redis = new MessageQueueService();

$message = $redis->popMessage();

$categoryId = $message->category_id;
$username   = $message->username;
$content    = $message->content;

$query = "INSERT INTO  `tweets`
                (`category_id`, `username`, `content`)
                VALUES ({$categoryId}, '{$username}','{$content}')";

$pdo->make($query);