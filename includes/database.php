<?php 
class Database{
    function __construct(){
        self::$con = new PDO("mysql:host=".$_ENV["DB_IP"].";port=".$_ENV["DB_PORT"].";dbname=".$_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    function query($query, $params = null)
    {
        if ($params == null) {
            return self::$con->query($query);
        }
        $stmt = self::$con->prepare($query);
        return $stmt->execute($params);
    }

    function exec($query, $params = null)
    {
        if ($params == null) {
            return self::$con->exec($query);
        }
        $stmt = self::$con->prepare($query);
        return $stmt->execute($params);
    }

}
?>