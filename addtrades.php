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
    $locations = $db->query("SELECT * FROM points_of_interest WHERE world='Overworld' ORDER BY created_at DESC");
    $items = $db->query("SELECT * FROM items");

    $errors = [];

    $defaultValues = [
        "location" => ["id" => ""],
        "first_item" => "",
        "first_item_amount" => "",
        "secondary_item" => "",
        "secondary_item_amount" => "",
        "return_item" => "",
        "return_item_amount" => "",

        "name" => "",
        "price" => ""
    ];

    if(isset($_POST["submit"])) {
        if(!isset($_POST["_type"])) {
            die("SOMETHING WENT WRONG");
        }

        if(!isset($_POST["location"])) {
            $errors["location"] = "You need to choose a location";
        } else {
            $location = $db->query("SELECT * FROM points_of_interest WHERE world='Overworld' AND id=:id", [ "id" => $_POST["location"] ]);

            if(count($location) <= 0)
                $errors['location'] = "You need to choose a location";
            else
                $defaultValues["location"] = $location[0];
        }

        if($_POST["_type"] == "trade") {

            $hasSecondaryItem = false;

            if(!isset($_POST["first_item"])) {
                $errors["first_item"] = "You need to select an item";
            } else {
                $item = $db->query("SELECT * FROM items WHERE id=:id", [ "id" => $_POST["first_item"] ]);

                if(count($item) <= 0)
                    $errors['first_item'] = "You need to choose an item";
                else
                    $defaultValues["first_item"] = $item[0];
            }

            if(!isset($_POST["first_item_amount"]) || !Validator::isNumber($_POST["first_item_amount"]) || intval($_POST["first_item_amount"]) <= 0)
                $errors["first_item_amount"] = "Can't be empty and must be 1 or over";
            else
                $defaultValues["first_item_amount"] = $_POST["first_item_amount"];

            if(isset($_POST["secondary_item"]) && $_POST["secondary_item"] != "") {
                $item = $db->query("SELECT * FROM items WHERE id=:id", [ "id" => $_POST["secondary_item"] ]);

                if(count($item) <= 0)
                    $errors['secondary_item'] = "You need to choose an item";
                else
                    $defaultValues["secondary_item"] = $item[0];

                if(!isset($_POST["secondary_item_amount"]) || !Validator::isNumber($_POST["secondary_item_amount"]) || intval($_POST["secondary_item_amount"]) <= 0)
                    $errors["secondary_item_amount"] = "Can't be empty and must be 1 or over";
                else
                    $defaultValues["secondary_item_amount"] = $_POST["secondary_item_amount"];

                $hasSecondaryItem = true;
            }


            if(!isset($_POST["return_item"])) {
                $errors["return_item"] = "You need to select an item";
            } else {
                $item = $db->query("SELECT * FROM items WHERE id=:id", [ "id" => $_POST["return_item"] ]);

                if(count($item) <= 0)
                    $errors['return_item'] = "You need to choose an item";
                else
                    $defaultValues["return_item"] = $item[0];
            }

            if(!isset($_POST["return_item_amount"]) || !Validator::isNumber($_POST["return_item_amount"]) || intval($_POST["return_item_amount"]) <= 0)
                $errors["return_item_amount"] = "Can't be empty and must be 1 or over";
            else
                $defaultValues["return_item_amount"] = $_POST["return_item_amount"];

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

                Notification::success("Trade has successfully been added");
            }
        } else if($_POST["_type"] == "enchantment") {
            
            if(!isset($_POST["name"]) || $_POST["name"] == "")
                $errors["name"] = "Must contain atleast one character"; 
            else
                $defaultValues["name"] = $_POST["name"];

            if(!isset($_POST["price"]) || !Validator::isNumber($_POST["price"]) || intval($_POST["price"]) <= 0)
                $errors["price"] = "Can't be empty and must be 1 or over";
            else
                $defaultValues["price"] = $_POST["price"];

            if(count($errors) <= 0) {
                $db->exec("INSERT INTO enchantments(user_id, poi_id, name, price) VALUES (:user_id, :poi_id, :name, :price)", [
                    "user_id" => Auth::userId(),
                    "poi_id" => $_POST["location"],
                    "name" => $_POST["name"],
                    "price" => $_POST["price"]
                ]);

                Notification::success("Enchantment has successfully been added");
            }
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
    <!--FontAwsome link-->
    <link rel="stylesheet" href="styles/font-awesome-4.7.0/css/font-awesome.min.css">

    <!--Favicon-->
    <link rel="icon" type="image/png" href="/favicon/favicon.ico" />
    <link rel="stylesheet" href="/styles/style.css">
</head>

<body>
    <?php require('navbar.php'); ?>

    <?php require('notifications.php'); ?>

    <?php if(isset($_GET["type"]) && $_GET["type"] == "trade"): ?>
        <div class="container" id="inner-container">
            <h2>Add Trades</h2>
            <p><b>Put in what trades your villagers have to offer.</b></p>
           <!-- Location --> 
            <form method="POST">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Droppdown with worlds -->
                        <div class="form-group">
                            <select class="form-control mb-1 <?php echo isset($errors["location"]) ? "is-invalid" : ""; ?>" name="location">
                                <option value="">Select Location</option>
                                <option value="">------------</option>
                                <?php foreach ($locations as $l) : ?>
                                    <option <?php echo $l["id"] == $defaultValues["location"]["id"] ? "selected" : ""; ?> value="<?php echo $l["id"]; ?>"><?php echo $l["name"]; ?></option>
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
                            <select class="form-control mb-1 <?php echo isset($errors["first_item"]) ? "is-invalid" : ""; ?>" name="first_item" data-custom-dropdown data-custom-dropdown-data="<?php echo base64_encode(json_encode($items)); ?>">
                                <?php if($defaultValues["first_item"] == ""): ?>
                                    <option value="">Select First Item</option>
                                <?php else: ?>
                                    <option value="<?php echo $defaultValue["first_item"]["id"]; ?>"><?php echo $defaultValues["first_item"]["name"]; ?></option>
                                <?php endif; ?>
                            </select>
                            <?php if(isset($errors['first_item'])): ?>
                                <small class="text-danger"><?php echo $errors["first_item"]; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Amount</span>
                                </div>
                                <input type="number" class="form-control <?php echo isset($errors["first_item_amount"]) ? "is-invalid" : ""; ?>" name="first_item_amount" value="<?php echo $defaultValues["first_item_amount"] ?>">
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
                            <select class="form-control mb-1 <?php echo isset($errors["secondary_item"]) ? "is-invalid" : ""; ?>" name="secondary_item" data-custom-dropdown data-custom-dropdown-data="<?php echo base64_encode(json_encode($items)); ?>">
                                <?php if($defaultValues["secondary_item"] == ""): ?>
                                    <option value="">Select Secondary Item</option>
                                <?php else: ?>
                                    <option value="<?php echo $defaultValues["secondary_item"]["id"]; ?>"><?php echo $defaultValues["secondary_item"]["name"]; ?></option>
                                <?php endif; ?>
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
                                <input type="number" class="form-control <?php echo isset($errors["secondary_item_amount"]) ? "is-invalid" : ""; ?>" name="secondary_item_amount" <?php echo $defaultValues["secondary_item_amount"]; ?>>
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
                            <select class="form-control mb-1 <?php echo isset($errors["return_item"]) ? "is-invalid" : ""; ?>" name="return_item" data-custom-dropdown data-custom-dropdown-data="<?php echo base64_encode(json_encode($items)); ?>">
                                <?php if($defaultValues["return_item"] == ""): ?>
                                    <option value="">Select What You Get</option>
                                <?php else: ?>
                                    <option value="<?php echo $defaultValues["return_item"]["id"]; ?>"><?php echo $defaultValues["return_item"]["name"]; ?></option>
                                <?php endif; ?>
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
                                <input type="number" class="form-control <?php echo isset($errors["return_item_amount"]) ? "is-invalid" : ""; ?>" name="return_item_amount" <?php echo $defaultValues["return_item_amount"]; ?>>
                            </div>
                            <?php if(isset($errors['return_item_amount'])): ?>
                                <small class="text-danger"><?php echo $errors["return_item_amount"]; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!--Button-->
                <div>
                    <input type="hidden" name="_type" value="trade">
                    <input type="submit" class="btn btn-light" name="submit" value="Add" >
                </div>
            </form>
        </div>
    </div>

    <?php elseif(isset($_GET["type"]) && $_GET["type"] == "enchantment"): ?>

    <div class="conatiner">
        <div class="container" id="inner-container">
            <h2>Add Enchantments</h2>
            <p><b>Put in what enchantments your villagers have to offer.</b></p>
            <form method="POST">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Droppdown with worlds -->
                        <div class="form-group">
                            <select class="form-control mb-1 <?php echo isset($errors["location"]) ? "is-invalid" : ""; ?>" name="location">
                                <option value="">Select Location</option>
                                <option value="">------------</option>
                                <?php foreach ($locations as $l) : ?>
                                    <option <?php echo $l["id"] == $defaultValues["location"]["id"] ? "selected" : ""; ?> value="<?php echo $l["id"]; ?>"><?php echo $l["name"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(isset($errors['location'])): ?>
                                <small class="text-danger"><?php echo $errors["location"]; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-6">
                        <!-- Input Enchantment -->
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Enchantment</span>
                                </div>
                                <input type="text" name="name" class="form-control <?php echo isset($errors["name"]) ? "is-invalid" : ""; ?>" placeholder="Sharpness V">
                            </div>
                            <?php if(isset($errors['name'])): ?>
                                <small class="text-danger"><?php echo $errors["name"]; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <!-- Input Emeralds -->
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img src="/images/items/emerald.png" width="20" height="20">
                                    </span>
                                </div>
                                <input type="number" class="form-control <?php echo isset($errors["price"]) ? "is-invalid" : ""; ?>" name="price" placeholder="How many emeralds it costs">
                            </div>
                            <?php if(isset($errors['price'])): ?>
                                <small class="text-danger"><?php echo $errors["price"]; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!--Button-->
                <div>
                    <input type="hidden" name="_type" value="enchantment">
                    <input type="submit" name="submit" class="btn btn-light" value="Add">
                </div>
            </form>
        </div>

<?php else: ?>
    <?php
        Notification::danger("Invalid type");
        header("Location: index.php");
        die();
    ?>
<?php endif; ?>

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
