<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Notification {

    private static function set($type, $message) {
        $_SESSION['_notification'] = [
            "type" => $type,
            "message" => $message
        ];
    }

    static function danger($message) {
        self::set("danger", $message);
    }

    static function success($message) {
        self::set("success", $message);
    }

    static function info($message) {
        self::set("info", $message);
    }

    static function warning($message) {
        self::set("warning", $message);
    }


    static function isAvailable() {
        return isset($_SESSION['_notification']);
    }

    static function get() {
        return $_SESSION['_notification'];
    }

    static function use() {
        $notification = $_SESSION['_notification'];
        unset($_SESSION['_notification']);
        return $notification;
    }
}

?>
