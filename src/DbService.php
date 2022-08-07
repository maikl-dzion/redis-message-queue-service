<?php

namespace Dzion\MessageQueue;

class DbService {

    protected  $pdo;
    protected  $config;

    public function __construct(array $config) {
        $this->config = $config;
        $this->connect();
    }

    protected  function connect(){

        $HOST     = $this->config['host'];
        $DRIVER   = $this->config['driver'];
        $DBNAME   = $this->config['dbname'];
        $USER     = $this->config['user'];
        $PASSWORD = $this->config['password'];

        $option = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => true,
        ];

        $dsn = $DRIVER . ':host='.$HOST.';dbname='.$DBNAME.';charset=utf8';
        $this->pdo = new \PDO($dsn, $USER, $PASSWORD, $option);
    }

    public function make(string $query, $args = []) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);
        return $stmt;
    }

    public function select(string $query, $args = []) {
        $stmt = $this->make($query, $args);
        return $stmt->fetchAll();
    }

}