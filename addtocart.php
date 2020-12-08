<?php
include_once "./includes/cart.php";

header("Content-type: application/json");

$json = file_get_contents('php://input');
$data = json_decode($json, true);


if (isset($data["id"])) {
    Cart::add($data["id"]);
    header("Content-type: application/json");
    echo (json_encode(["amount" => Cart::totalAmount()]));
    die();
}

echo (json_encode(["message" => "Something went wrong"]));
