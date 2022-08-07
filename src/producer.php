<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: text/html; charset=utf-8');

$dbConfig = require __DIR__ . '/../src/config.php';
require __DIR__ . '/../vendor/autoload.php';

use Dzion\MessageQueue\DbService;
use Dzion\MessageQueue\MessageQueueService;

$pdo   = new DbService($dbConfig);
$redis = new MessageQueueService();

$results = [];

if(!empty($_GET['action'])) {

   $action = trim($_GET['action']);
   switch ($action) {
       case 'get-categories' :
           $query = 'SELECT * FROM `tweet_category` ORDER BY `id`';
           $results = $pdo->select($query);
           break;

       case 'get-tweets' :
           $query = 'SELECT tweets.*, cat.title AS cat_title FROM `tweets` 
                     LEFT JOIN tweet_category cat ON cat.id = tweets.category_id
                     ORDER BY tweets.`id` DESC';
           $results = $pdo->select($query);
           break;

       case 'tweets-count-in-queue' :
           $count = $redis->getCountMessages();
           $results['tweet_count'] = $count;
           break;

       case 'add-tweet' :
           $message = (array)json_decode(file_get_contents('php://input'));
           $status = $redis->setMessage($message);
           $results = $redis->getMessagesList();
           break;
   }

}

die(json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

