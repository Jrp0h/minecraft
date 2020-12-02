<?php
include_once "./includes/validation.php";
include_once "./includes/database.php";

$db = new Database();
$result = $db->query("SELECT poi.*, users.dc_username AS user_dc_username, users.mc_username AS user_mc_username
FROM points_of_interest AS poi
INNER JOIN users
ON poi.user_id = users.id
ORDER BY poi.created_at DESC;");

$value = 0;

$worlds = ["Overworld", "Nether", "End"];
$categories = ["Home", "Biome", "Temple", "Spawner", "Misc"];

$errors = [];

if (isset($_GET["search"])) {

    if (isset($_GET["world"]) && $_GET["world"] != "") {
        if (!in_array($_GET["world"], $worlds)) {
            $errors["world"] = "You need to choose one of the three options";
        }
        $value += 1;
    }
    if (isset($_GET["category"]) && $_GET["category"] != "") {
        if (!in_array($_GET["category"], $categories)) {
            $errors["category"] = "You need to choose one of the options";
        }
        $value += 2;
    }

    $xExists = false;
    $zExists = false;

    if (isset($_GET["x"]) && $_GET["x"] != "") {
        $xExists = true;
        if (!Validator::isNumber($_GET["x"])) {
            $errors["x"] = "X must be a number";
        }
    }
    if (isset($_GET["z"]) && $_GET["z"] != "") {
        $zExists = true;
        if (!Validator::isNumber($_GET["z"])) {
            $errors["z"] = "z must be a number";
        }
    }

    if ($xExists || $zExists) {
        // X set but not Z
        if ($xExists && !$zExists) {
            $errors["z"] = "Need a value";
        } elseif ($zExists && !$xExists) {
            $errors["x"] = "Need a value";
        } else {
            $value += 4;
        }
    }

    if ($value == 4 || $value == 6) {
        $errors["world"] = "World is reguired to get position";
    }
    if (count($errors) > 0) {
        $value = 0;
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!--FontAwsome link-->
    <link rel="stylesheet" href="styles/font-awesome-4.7.0/css/font-awesome.min.css">

    <!--Favicon-->
    <link rel="icon" type="image/png" href="/favicon/favicon.ico" />

    <link rel="stylesheet" href="/styles/style.css">
</head>

<body>
    <?php require('navbar.php'); ?>

    <!-- Container for all Content -->
    <!-- Search Container -->
    <div class="container" id="inner-container">
        <form method="GET">
            <h2>Filter</h2>
            <div class="row">
                <div class="col-lg-3">
                    <!-- Input X Position -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">X</span>
                        </div>
                        <input name="x" type="text" class="form-control" placeholder="-216">
                    </div>
                </div>

                <div class="col-lg-3">
                    <!-- Input X Position -->
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">X</span>
                            </div>
                            <input name="x" type="text" class="form-control" placeholder="-216">
                            <small class="text-danger">You need to have a X coord aswell</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <!-- Input Z Position -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Z</span>
                        </div>
                        <input name="z" type="text" class="form-control" placeholder="900">
                    </div>
                </div>

                <div class="col-lg-3">
                    <!-- Input Z Position -->
                    <div clas="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Z</span>
                            </div>
                            <input name="z" type="text" class="form-control" placeholder="900">
                            <small class="text-danger">You need to have a Z coord aswell</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <!-- Droppdown with worlds -->
                    <select name="world" class="form-control mb-3">
                        <option value="">Select World</option>
                        <option value="">------------</option>
                        <option>Overworld</option>
                        <option>Nether</option>
                        <option>End</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <!-- Droppdown for locations types -->
                    <select name="category" class="form-control mb-3">
                        <option value="">Select Category</option>
                        <option value="">------------</option>
                        <option>Home</option>
                        <option>Biome</option>
                        <option>Spawner</option>
                        <option>Temple</option>
                        <option>Misc</option>
                    </select>
                </div>
            </div>


            <input type="submit" class="btn btn-light mb-4" value="Search" name="search">
        </form>

        <!--Flöde Point of Interest-->
        <h2>Points of interest</h2>
        <?php foreach ($result as $key => $row) :  ?>
            <div class="card border-dark mb-3 card-coords" style="max-width: 100%;">
                <div class="card-header bg-transparent border-dark"><b><?php echo $row["name"]; ?></b></div>
                <div class="card-body text-dark">
                    <h6 class="card-title">X: <?php echo $row["x"]; ?> <?php echo $row["y"] == null ? "" : "Y: " . $row["y"]; ?> Z: <?php echo $row["z"]; ?></h6>
                    <p class="card-text">Description: <?php echo $row["description"]; ?></p>
                </div>
                <div class="card-footer bg-transparent border-dark">
                    <div class="row">
                        <div class="col">
                            <?php echo $row["world"]; ?> -- <?php echo $row["category"]; ?>
                        </div>
                        <div class="col text-right">
                            <?php echo $row["user_mc_username"] . "/" . $row["user_dc_username"]; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="scripts/main.js" async defer></script>
</body>

</html>