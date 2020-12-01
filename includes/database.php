<?php 
require_once "./vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

class Database{
    var $con;
    function __construct(){
        $this->con = new PDO("mysql:host=".$_ENV["DB_IP"].";port=".$_ENV["DB_PORT"].";dbname=".$_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    function query($query, $params = null)
    {
        if ($params == null) {
            return $this->con->query($query);
        }
        $stmt = $this->con->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    function exec($query, $params = null)
    {
        if ($params == null) {
            return $this->con->exec($query);
        }
        $stmt = $this->con->prepare($query);
        return $stmt->execute($params);
    }

}
