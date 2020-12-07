<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['shoppingcart'])) {
    $_SESSION['shoppingcart'] = [];
}

require_once "./includes/database.php";


class Cart
{

    static $items = [];

    static function add($id)
    {
        self::$items = $_SESSION['shoppingcart'];

        if (isset(self::$items[$id]))
            self::$items[$id]++;
        else
            self::$items[$id] = 1;

        $_SESSION['shoppingcart'] = self::$items;
    }

    static function remove($id)
    {
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
        self::$items = $_SESSION['shoppingcart'];
        $db = new Database();
        $sum = 0;

        foreach (self::$items as $id => $amount) {
            $price = $db->query("SELECT price FROM enchantments WHERE id = :id;", ["id" => $id]);
            $sum += $price[0]["price"] * $amount;
        }
        return $sum;
    }

    static function returnAmount()
    {
        self::$items = $_SESSION['shoppingcart'];
        $amount = 0;
        foreach (self::$items as $key => $item) {
            $amount += $item;
        }
        return $amount;
    }
}
