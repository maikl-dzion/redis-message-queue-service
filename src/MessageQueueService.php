<?php

namespace Dzion\MessageQueue;

class MessageQueueService {

    protected $redis;
    protected $queueName;

    public function __construct($queueName = 'message-list', $host = '127.0.0.1', $port = 6379) {
        $this->redis = new \Redis();
        $this->redis->connect($host, $port);
        $this->queueName = $queueName;
    }

    public function setMessage($message) {
        $message = json_encode($message);
        $this->redis->rpush($this->queueName, $message);
    }

    public function popMessage() {
        $message = $this->redis->lpop($this->queueName);
        return json_decode($message);
    }

    public function getMessagesList() {
        $messages =  $this->redis->lrange($this->queueName, 0, -1);
        foreach ($messages as $key => $message) {
            $messages[$key] = json_decode($message);
        }
        return $messages;
    }

    public function getCountMessages() {
        return $this->redis->llen($this->queueName);
    }
}
