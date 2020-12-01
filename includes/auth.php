<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "./includes/database.php";

class Auth
{
    static function isLoggedIn()
    {
        return isset($_SESSION["user_id"]);
    }

    static function user()
    {
        $db = new Database();
        $result = $db->query("SELECT id, dc_username, mc_username FROM users WHERE id = :id", ["id" => $_SESSION["user_id"]]);
        $result = $result[0];
        return $result;
    }
}
