<?php
    include_once "./includes/validation.php";
    include_once "./includes/database.php";
    require_once "./includes/auth.php";
    require_once "./includes/notification.php";

    if (!Auth::isLoggedIn()) {
        Notification::warning("You must be logged in too add trades");
        header("Location: login.php");
        die();
    }

    $db = new Database();
    $locations = $db->query("SELECT * FROM points_of_interest WHERE world='Overworld'");
    $items = $db->query("SELECT * FROM items");

    $errors = [];

    if(isset($_POST["submit"])) {
        if(!isset($_POST["type"])) {
            die("SOMETHING WENT WRONG");
        }

        if(!isset($_POST["location"])) {
            $errors["location"] = "You need to choose a location";
        } else {
            $location = $db->query("SELECT * FROM points_of_interest WHERE world='Overworld' AND id=:id", [ "id" => $_POST["location"] ]);

            if(count($location) <= 0)
                $errors['location'] = "You need to choose a location";
        }

        if($_POST["type"] == "trade") {

            $hasSecondaryItem = false;

            if(!isset($_POST["first_item"])) {
                $errors["first_item"] = "You need to select an item";
            } else {
                $item = $db->query("SELECT * FROM items WHERE id=:id", [ "id" => $_POST["first_item"] ]);

                if(count($item) <= 0)
                    $errors['first_item'] = "You need to choose an item";
            }

            if(!isset($_POST["first_item_amount"]) || !Validator::isNumber($_POST["first_item_amount"]) || intval($_POST["first_item_amount"]) <= 0) {
                $errors["first_item_amount"] = "Can't be empty and must be 1 or over";
            }

            if(isset($_POST["secondary_item"]) && $_POST["secondary_item"] != "") {
                $item = $db->query("SELECT * FROM items WHERE id=:id", [ "id" => $_POST["secondary_item"] ]);

                if(count($item) <= 0)
                    $errors['secondary_item'] = "You need to choose an item";

                if(!isset($_POST["secondary_item_amount"]) || !Validator::isNumber($_POST["secondary_item_amount"]) || intval($_POST["secondary_item_amount"]) <= 0) {
                    $errors["secondary_item_amount"] = "Can't be empty and must be 1 or over";
                }

                $hasSecondaryItem = true;
            }


            if(!isset($_POST["return_item"])) {
                $errors["return_item"] = "You need to select an item";
            } else {
                $item = $db->query("SELECT * FROM items WHERE id=:id", [ "id" => $_POST["return_item"] ]);

                if(count($item) <= 0)
                    $errors['return_item'] = "You need to choose an item";
            }

            if(!isset($_POST["return_item_amount"]) || !Validator::isNumber($_POST["return_item_amount"]) || intval($_POST["return_item_amount"]) <= 0) {
                $errors["return_item_amount"] = "Can't be empty and must be 1 or over";
            }

            if(count($errors) <= 0) {
                if($hasSecondaryItem)
                {
                    $db->exec("INSERT INTO trades(user_id, poi_id, item_id, item_amount, secondary_item_id, secondary_item_amount, return_item_id, return_item_amount) VALUES (:user_id, :poi_id, :item_id, :item_amount, :secondary_item_id, :secondary_item_amount, :return_item_id, :return_item_amount)", [
                        "user_id" => Auth::userId(),
                        "poi_id" => $_POST["location"],
                        "item_id" => $_POST["first_item"],
                        "item_amount" => $_POST["first_item_amount"],
                        "secondary_item_id" => $_POST["secondary_item"], 
                        "secondary_item_amount" => $_POST["secondary_item_amount"], 
                        "return_item_id" => $_POST["return_item"], 
                        "return_item_amount" => $_POST["return_item_amount"]
                    ]);
                }
                else {
                    $db->exec("INSERT INTO trades(user_id, poi_id, item_id, item_amount, return_item_id, return_item_amount) VALUES (:user_id, :poi_id, :item_id, :item_amount, :return_item_id, :return_item_amount)", [
                        "user_id" => Auth::userId(),
                        "poi_id" => $_POST["location"],
                        "item_id" => $_POST["first_item"],
                        "item_amount" => $_POST["first_item_amount"],
                        "return_item_id" => $_POST["return_item"], 
                        "return_item_amount" => $_POST["return_item_amount"]
                    ]);
                }
            }
        } else if($_POST["type"] == "enchantment") {

        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
        </script>
    <link rel="stylesheet" href="/styles/style.css">
</head>

<body>
    <?php require('navbar.php'); ?>

    <?php require('notifications.php'); ?>

        <div class="container" id="inner-container">
            <h2>Add Emerald Trades</h2>
            <p><b>Put in what trades your villagers have to offer.</b></p>
           <!-- Location --> 
            <form method="POST">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Droppdown with worlds -->
                        <div class="form-group">
                            <select class="form-control mb-1" name="location">
                                <option value="">Select Location</option>
                                <option value="">------------</option>
                                <?php foreach ($locations as $l) : ?>
                                    <option value="<?php echo $l["id"]; ?>"><?php echo $l["name"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(isset($errors['location'])): ?>
                                <small class="text-danger"><?php echo $errors["location"]; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

               <!-- First Item --> 
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <select class="form-control mb-1" name="first_item" data-custom-dropdown data-custom-dropdown-data="<?php echo base64_encode(json_encode($items)); ?>">
                                <option value="">Select First Item</option>
                            </select>
                            <?php if(isset($errors['secondary_item_amount'])): ?>
                                <small class="text-danger"><?php echo $errors["secondary_item_amount"]; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Amount</span>
                                </div>
                                <input type="number" class="form-control" name="first_item_amount">
                            </div>
                            <?php if(isset($errors['first_item_amount'])): ?>
                                <small class="text-danger"><?php echo $errors["first_item_amount"]; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

               <!-- Secondary Item --> 
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <select class="form-control mb-1" name="secondary_item" data-custom-dropdown data-custom-dropdown-data="<?php echo base64_encode(json_encode($items)); ?>">
                                <option value="">Select Secondary Item</option>
                            </select>
                            <?php if(isset($errors['secondary_item'])): ?>
                                <small class="text-danger"><?php echo $errors["secondary_item"]; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Amount</span>
                                </div>
                                <input type="number" class="form-control" name="secondary_item_amount">
                            </div>
                            <?php if(isset($errors['secondary_item_amount'])): ?>
                                <small class="text-danger"><?php echo $errors["secondary_item_amount"]; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

               <!-- What you get --> 
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <select class="form-control mb-1" name="return_item" data-custom-dropdown data-custom-dropdown-data="<?php echo base64_encode(json_encode($items)); ?>">
                                <option value="">Select What You Get</option>
                            </select>
                            <?php if(isset($errors['return_item'])): ?>
                                <small class="text-danger"><?php echo $errors["return_item"]; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Amount</span>
                                </div>
                                <input type="number" class="form-control" name="return_item_amount">
                            </div>
                            <?php if(isset($errors['return_item_amount'])): ?>
                                <small class="text-danger"><?php echo $errors["return_item_amount"]; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!--Button-->
                <div>
                    <input type="hidden" name="type" value="trade">
                    <input type="submit" class="btn btn-light" name="submit" value="Add" >
                </div>
            </form>
        </div>
    </div>

    <div class="conatiner">
        <div class="container" id="inner-container">
            <h2>Add Enchantments</h2>
            <p><b>Put in what enchantments your villagers have to offer</b></p>
            <div class="row">
            </div>
            <div class="row">

                <div class="col-lg-6">
                    <!-- Input Enchantment -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Enchantment</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Sharpness V">
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- Input Emeralds -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <img src="/images/emerald.png" width="20" height="20">
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="How many emeralds it costs">
                    </div>
                </div>
            </div>

            <!--Button-->
            <div>
                <button class="btn btn-light">Add</button>
            </div>
        </div>

    <!-- DONT TOUCH!!!!! -->
    <div id="dd" class="custom-dropdown">
        <div class="custom-dropdown-search">
            <input placeholder="Search" type="text" class="form-control" id="dd-search">
        </div>
        <hr>
        <div class="custom-dropdown-items" id="dd-items">
                <div class="custom-dropdown-item-group">
                    <img src="" alt="" class="custom-dropdown-item-img">
                    <p class="custom-dropdown-item-title"></p>
                </div>
        </div>    
    </div>
    <script src="scripts/main.js"></script>
</body>

</html>
