<?php

class Db {

    protected $driver;
    protected $host;
    protected $dbname;
    protected $user;
    protected $passwad;

    function __construct(){
        $this->driver   = 'mysql';
        $this->host     = 'localhost';
        $this->dbname   = 'amazon';
        $this->user     = 'app';
        $this->passwad  = '';
    }

    function connect(){
        // MySQL接続
        try {
            $pdo = new PDO(
                "{$this->driver}:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->user,
                $this->passwad,
                array(PDO::ATTR_EMULATE_PREPARES => false)
            );
        } catch (PDOException $e) {
            error_log('データベース接続失敗。'.$e->getMessage());
            return false;
        }

        return $pdo;
    }
}

?>
