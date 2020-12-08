<?php
include_once "/includes/cart.php";

if (isset($_POST["id"])) {
    Cart::add(intval($_POST["id"]));
    header("Content-Type: application/json");
    echo (json_encode(["amount" => Cart::totalAmount()]));
}
