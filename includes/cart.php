<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



require_once "./includes/database.php";


class Cart
{

    static $items = [];

    static function add($id)
    {
        if (!isset($_SESSION['shoppingcart'])) {
            $_SESSION['shoppingcart'] = [];
        }

        self::$items = $_SESSION['shoppingcart'];

        if (isset(self::$items[$id]))
            self::$items[$id]++;
        else
            self::$items[$id] = 1;

        $_SESSION['shoppingcart'] = self::$items;
    }

    static function remove($id)
    {
        if (!isset($_SESSION['shoppingcart'])) {
            $_SESSION['shoppingcart'] = [];
        }

        self::$items = $_SESSION['shoppingcart'];
        if (isset(self::$items[$id]) && self::$items[$id] > 1) {
            self::$items[$id]--;
        } else {
            unset(self::$items[$id]);
        }
        $_SESSION['shoppingcart'] = self::$items;
    }

    // For debugging can delete later
    static function return()
    {
        return self::$items;
    }

    static function returnPrice()
    {
        if (!isset($_SESSION['shoppingcart'])) {
            $_SESSION['shoppingcart'] = [];
        }

        self::$items = $_SESSION['shoppingcart'];
        $db = new Database();
        $sum = 0;

        foreach (self::$items as $id => $amount) {
            $price = $db->query("SELECT price FROM enchantments WHERE id = :id;", ["id" => $id]);
            $sum += $price[0]["price"] * $amount;
        }
        return $sum;
    }

    static function totalAmount()
    {
        if (!isset($_SESSION['shoppingcart'])) {
            $_SESSION['shoppingcart'] = [];
        }

        self::$items = $_SESSION['shoppingcart'];
        $amount = 0;
        foreach (self::$items as $key => $item) {
            $amount += $item;
        }
        return $amount;
    }

    static function returnAll()
    {
        if (!isset($_SESSION['shoppingcart'])) {
            $_SESSION['shoppingcart'] = [];
        }

        self::$items = $_SESSION['shoppingcart'];
        $db = new Database();

        $data = [];

        foreach (self::$items as $id => $amount) {
            $temp = $db->query("SELECT en.*, poi.name AS poi_name FROM enchantments AS en INNER JOIN points_of_interest AS poi ON en.poi_id=poi.id WHERE en.id = :id", ["id" => $id]);
            $temp[0]["amount"] = $amount;
            $temp[0]["total_price"] = $amount * $temp[0]["price"];
            $data[] = $temp[0];
        }
        return $data;
    }
    static function clear()
    {
        $_SESSION['shoppingcart'] = [];
    }
}
