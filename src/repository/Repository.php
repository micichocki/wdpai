<?php

require_once __DIR__ . '/../../Database.php';

class Repository
{

    protected static $instance;
    protected $database;


    private function __construct()
    {
        $this->database = new Database();
    }


    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
