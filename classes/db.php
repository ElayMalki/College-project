<?php
include __DIR__.'/../config/db.php';
?>
<?php


class db {
    public $pdo;

    function __construct() {
        try
        {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .';' , DB_USER , DB_PASS , array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_ENCODING  ) );
            $this->pdo->exec("SET time_zone=" . DB_TIMEZONE);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            trigger_error($e->getMessage());
        }
    }

}