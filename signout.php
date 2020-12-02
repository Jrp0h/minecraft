<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

require_once "./includes/notification.php";

unset($_SESSION["user_id"]);
Notification::info("You've been signed out");
header("Location: login.php");
?>
