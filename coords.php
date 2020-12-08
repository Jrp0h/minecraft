<?php
include_once "./includes/validation.php";
include_once "./includes/database.php";
require_once "./includes/auth.php";
require_once "./includes/notification.php";

if (!Auth::isLoggedIn()) {
    Notification::warning("You must be logged in too add coords");
    header("Location: login.php");
    die();
}

$defaultValues = [
    "x" => "",
    "y" => "",
    "z" => "",
    "name" => "",
    "description" => "",
    "world" => "",
    "category" => "",
    "looted" => 0

];

$edit = false;

if (isset($_GET["type"]) && $_GET["type"] == "edit") {
    if (!isset($_GET["id"])) {
        Notification::danger("Invalid id");
        header("Location: index.php");
        die();
    } else {
        $db = new Database();
        $poi = $db->query("SELECT * FROM points_of_interest WHERE id=:id", ["id" => $_GET["id"]]);
        if (count($poi) <= 0) {
            Notification::danger("Invalid id");
            header("Location: index.php");
            die();
        } else {
            if (Auth::userId() != $poi[0]["user_id"]) {
                Notification::danger("You can´t edit another users coordinates");
                header("Location: index.php");
                die();
            }
            $defaultValues["x"] = $poi[0]["x"];
            //Y måste inte vara satt
            if ($poi[0]["y"] == null) {
                $defaultValues["y"] = "";
            } else {
                $defaultValues["y"] = $poi[0]["y"];
            }
            $defaultValues["z"] = $poi[0]["z"];
            $defaultValues["name"] = $poi[0]["name"];
            $defaultValues["description"] = $poi[0]["description"];
            $defaultValues["world"] = $poi[0]["world"];
            $defaultValues["category"] = $poi[0]["category"];
            $defaultValues["looted"] = $poi[0]["looted"];
            $edit = true;
        }
    }
}

$errors = [];

$y = null;

$worlds = ["Overworld", "Nether", "End"];
$categories = ["Home", "Biome", "Temple", "Spawner", "Misc"];

if (isset($_POST["submit"])) {
    if (!isset($_POST["x"]) || !Validator::isNumber($_POST["x"])) {
        $errors["x"] = ("X can´t be empty or non-numeric");
    } else {
        $defaultValues["x"] = $_POST["x"];
    }
    if (isset($_POST["y"]) && $_POST["y"] != "") {
        $y = $_POST["y"];
        if (!Validator::isNumber($_POST["y"])) {
            $errors["y"] = ("Y can´t be non-numeric");
        }
    }
    if (!isset($_POST["z"]) || !Validator::isNumber($_POST["z"])) {
        $errors["z"] = ("Z can´t be empty or non-numeric");
    } else {
        $defaultValues["z"] = $_POST["z"];
    }

    if (!isset($_POST["world"]) || !in_array($_POST["world"], $worlds)) {
        $errors["world"] = ("You need to choose one of the three options");
    } else {
        $defaultValues["world"] = $_POST["world"];
    }
    if (!isset($_POST["category"]) || !in_array($_POST["category"], $categories)) {
        $errors["category"] = ("You need to choose one of the options");
    } else {
        $defaultValues["world"] = $_POST["world"];
    }
    if (!isset($_POST["description"]) || $_POST["description"] == "") {
        $errors["description"] = ("You need to put in a description");
    } else {
        $defaultValues["description"] = $_POST["description"];
    }
    if (!isset($_POST["name"]) || $_POST["name"] == "") {
        $errors["name"] = ("You need to put in a location name");
    } else {
        $defaultValues["name"] = $_POST["name"];
    }

    if (count($errors) <= 0) {
        $db = new Database();
        $looted = 0;

        if (isset($_POST["looted"])) {
            $looted = intval($_POST["looted"] == "on");
        }

        print_r($_POST["category"]);
        if (!$edit) {
            $db->exec(
                "INSERT INTO points_of_interest (user_id, name, x, y, z, looted, description, world, category) VALUES (:user_id, :name, :x, :y, :z, :looted, :description, :world, :category)",
                [
                    "user_id" => Auth::userId(),
                    "name" => $_POST["name"],
                    "x" => $_POST["x"],
                    "y" => $y,
                    "z" => $_POST["z"],
                    "description" => $_POST["description"],
                    "looted" => $looted,
                    "world" => $_POST["world"],
                    "category" => $_POST["category"]
                ]
            );

            Notification::success("Coords successfully added");
            header("Location: index.php");
            die();
        } else {
            $db->exec(
                "UPDATE points_of_interest SET name = :name, x = :x, y = :y, z = :z, looted = :looted, description = :description, world = :world, category = :category WHERE id = :id",
                [
                    "id" => $_GET["id"],
                    "name" => $_POST["name"],
                    "x" => $_POST["x"],
                    "y" => $y,
                    "z" => $_POST["z"],
                    "description" => $_POST["description"],
                    "looted" => $looted,
                    "world" => $_POST["world"],
                    "category" => $_POST["category"]
                ]
            );

            Notification::success("Coords successfully updated");
            header("Location: index.php");
            die();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Coords</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="/styles/style.css">
    <!--FontAwsome link-->
    <link rel="stylesheet" href="styles/font-awesome-4.7.0/css/font-awesome.min.css">
</head>

<body>

    <?php require('navbar.php'); ?>

    <?php require('notifications.php'); ?>

    <!--Provar så dom funkar-->

    <div class="container" id="inner-container">
        <h2><?php if (isset($_GET["type"]) && $_GET["type"] == "edit") : ?>Edit Point of Interest
            <?php else : ?>Add Point of Interest <?php endif; ?></h2>

        <form method="POST" action="#">
            <div class="row">

                <!--PHP if X sats-->
                <?php if (isset($errors["x"])) : ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <!-- Input X Position -->
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">X</span>
                                </div>
                                <input type="number" class="form-control is-invalid" placeholder="312" name="x">
                            </div>
                            <small class="text-danger"><?php echo $errors["x"]; ?></small>
                        </div>
                    </div>

                <?php else : ?>

                    <div class="col-lg-4">
                        <!-- Input X Position -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    X</span>
                            </div>
                            <input type="text" class="form-control" placeholder="-216" value="<?php echo $defaultValues["x"]; ?>" name="x">
                        </div>
                    </div>
                <?php endif; ?>

                <!--PHP if Y sats-->
                <?php if (isset($errors["y"])) : ?>
                    <div class="col-lg-4">
                        <!-- Input Y Position -->
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Y</span>
                                </div>
                                <input type="text" class="form-control is-invalid" placeholder="76" name="y">
                            </div>
                            <small class="text-danger"> <?php echo $errors["y"]; ?> </small>
                        </div>
                    </div>

                <?php else : ?>
                    <div class="col-lg-4">
                        <!-- Input Y Position -->
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Y</span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $defaultValues["y"]; ?>" placeholder="76" name="y">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


                <!--PHP if Z sats-->
                <?php if (isset($errors["z"])) : ?>
                    <div class="col-lg-4">
                        <!-- Input Z Position -->
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Z</span>
                                </div>
                                <input type="text" class="form-control is-invalid" placeholder="900" name="z">
                            </div>
                            <small class="text-danger"> <?php echo $errors["z"]; ?> </small>
                        </div>
                    </div>

                <?php else : ?>
                    <div class="col-lg-4">
                        <!-- Input Z Position -->
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Z</span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $defaultValues["z"]; ?>" placeholder="900" name="z">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <div class="row">

                <?php if (isset($errors["world"])) : ?>
                    <div class="col-lg-6">
                        <!-- Droppdown with worlds -->
                        <div class="form-group">
                            <select class="form-control mb-1 is-invalid" name="world">
                                <option>Select World</option>
                                <option>------------</option>
                                <?php foreach ($worlds as $w) : ?>
                                    <option value="<?php echo $w; ?>"><?php echo $w; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-danger">
                                <?php echo $errors["world"]; ?>
                            </small>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-lg-6">
                        <!-- Droppdown with worlds -->
                        <div class="form-group">
                            <select class="form-control mb-3" name="world">
                                <option>Select World</option>
                                <option>------------</option>
                                <?php foreach ($worlds as $w) : ?>
                                    <option <?php echo $defaultValues["world"] == $w ? "selected" : ""; ?> value="<?php echo $w; ?>"><?php echo $w; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($errors["category"])) : ?>
                    <div class="col-lg-6">
                        <!-- Droppdown for locations types -->
                        <div class="form-group">
                            <select class="form-control mb-1 is-invalid" name="category">
                                <option>Select Category</option>
                                <option>------------</option>
                                <?php foreach ($categories as $c) : ?>
                                    <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-danger">
                                <?php echo $errors["category"]; ?>
                            </small>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-lg-6">
                        <!-- Droppdown for locations types -->
                        <div class="form-group">
                            <select class="form-control mb-3" name="category" value="<?php echo isset($_POST["category"]) ? $_POST["category"] : ""; ?>">
                                <option>Select Category</option>
                                <option>------------</option>
                                <?php foreach ($categories as $c) : ?>
                                    <option <?php echo $defaultValues["category"] == $c ? "selected" : ""; ?> value="<?php echo $c; ?>"><?php echo $c; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row">
                <?php if (isset($errors["name"])) : ?>
                    <div class="col-lg-12">
                        <!-- Name of Location -->
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Name of location</span>
                                </div>
                                <input type="text" class="form-control is-invalid" placeholder="Marqus house" name="name">
                            </div>
                            <small class="text-danger">
                                <?php echo $errors["name"]; ?>
                            </small>
                        </div>
                    </div>
                <?php else : ?>


                    <div class="col-lg-12">
                        <!-- Name of Location -->
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Name of location</span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo $defaultValues["name"]; ?>" placeholder="Marqus house" name="name">
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

                <?php if (isset($errors["description"])) : ?>
                    <div class="col-lg-12">
                        <!-- Description -->
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Description</span>
                                </div>
                                <textarea class="form-control is-invalid" rows="5" name="description"></textarea>
                            </div>
                            <small class="text-danger">
                                <?php echo $errors["description"]; ?>
                            </small>
                        </div>
                    </div>

                <?php else : ?>
                    <div class="col-lg-12">
                        <!-- Description -->
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Description</span>
                                </div>
                                <textarea class="form-control" rows="5" name="description"><?php echo $defaultValues["description"]; ?></textarea>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Looted -->
            <div>

                <input type="checkbox" class="form-check-input ml-1" name="looted" <?php echo $defaultValues["looted"] ? "checked" : ""; ?>>
                <label class="form-check-label ml-4">Looted</label>
            </div>

            <!--Button-->
            <div>
                <input type="submit" class="btn btn-light mt-3" value="<?php if (isset($_GET["type"]) && $_GET["type"] == "edit") : ?>Edit<?php else : ?>Add <?php endif; ?>" name="submit">
            </div>
        </form>
    </div>

    <script src="scripts/main.js"></script>
</body>

</html>