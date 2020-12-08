<?php
include_once "./includes/validation.php";
include_once "./includes/database.php";
require_once "./includes/auth.php";


$queries = [
    // 0 - Default 
    "SELECT 
	points_of_interest.*,
	users.dc_username AS user_dc_username,
	users.mc_username AS user_mc_username
	FROM points_of_interest
	INNER JOIN users
	ON points_of_interest.user_id = users.id
	ORDER BY created_at DESC;",

    // 1 - World only
    "SELECT 
	points_of_interest.*,
	users.dc_username AS user_dc_username,
	users.mc_username AS user_mc_username
	FROM points_of_interest
	INNER JOIN users 
	ON points_of_interest.user_id = users.id
	WHERE world = :world
    ORDER BY created_at DESC;",

    // 2 - Category only
    "SELECT 
	points_of_interest.*,
	users.dc_username AS user_dc_username,
	users.mc_username AS user_mc_username
	FROM points_of_interest
	INNER JOIN users 
	ON points_of_interest.user_id = users.id
	WHERE category = :category
    ORDER BY created_at DESC;",

    // 3 - World and Category
    "SELECT 
	points_of_interest.*,
	users.dc_username AS user_dc_username,
	users.mc_username AS user_mc_username
	FROM points_of_interest
	INNER JOIN users 
	ON points_of_interest.user_id = users.id
	WHERE world = :world
	AND category = :category
    ORDER BY created_at DESC;",

    // 4 - Position only (INVALID)
    "",

    // 5 - Position and World
    "SELECT 
	points_of_interest.*,
	users.dc_username AS user_dc_username,
	users.mc_username AS user_mc_username,
	SQRT((POWER(x - :x,2) + POWER(z - :z,2))) AS distance
	FROM points_of_interest 
	INNER JOIN users 
	ON points_of_interest.user_id = users.id
	WHERE world = :world
    ORDER BY distance;",

    // 6 - Position and Category (INVALID)
    "",

    // 7 - Position, World and Category
    "SELECT 
	points_of_interest.*,
	users.dc_username AS user_dc_username,
	users.mc_username AS user_mc_username,
    SQRT((POWER(x - :x,2) + POWER(z - :z,2))) AS distance
    FROM points_of_interest 
	INNER JOIN users 
	ON points_of_interest.user_id = users.id
	WHERE world = :world
    AND category = :category
    ORDER BY distance;",
];


$worlds = ["Overworld", "Nether", "End"];
$categories = ["Home", "Biome", "Temple", "Spawner", "Misc"];

$value = 0;
$errors = [];

$params = [];

if (isset($_GET["search"])) {

    if (isset($_GET["world"]) && $_GET["world"] != "") {
        if (!in_array($_GET["world"], $worlds)) {
            $errors["world"] = "Invalid option";
        }
        $params["world"] = $_GET["world"];
        $value += 1;
    }
    if (isset($_GET["category"]) && $_GET["category"] != "") {
        if (!in_array($_GET["category"], $categories)) {
            $errors["category"] = "Invalid option";
        }
        $params["category"] = $_GET["category"];
        $value += 2;
    }

    $xExists = false;
    $zExists = false;

    if (isset($_GET["x"]) && $_GET["x"] != "") {
        $xExists = true;
        if (!Validator::isNumber($_GET["x"])) {
            $errors["x"] = "X must be a number";
        }
        $params["x"] = $_GET["x"];
    }
    if (isset($_GET["z"]) && $_GET["z"] != "") {
        $zExists = true;
        if (!Validator::isNumber($_GET["z"])) {
            $errors["z"] = "Z must be a number";
        }
        $z = $_GET["z"];
        $params["z"] = $_GET["z"];
    }

    if ($xExists || $zExists) {
        // X set but not Z
        if ($xExists && !$zExists) {
            $errors["z"] = "Z is needed to calculate distance";
        } elseif ($zExists && !$xExists) {
            $errors["x"] = "X is needed to calculate distance";
        }

        $value += 4;
    }

    if ($value == 4 || $value == 6) {
        $errors["world"] = "World is required to calculate distance";
    }

    if (count($errors) > 0) {
        $value = 0;
        $params = [];
    }
}

$db = new Database();
$result = $db->query($queries[$value], $params);

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

    <?php require('notifications.php'); ?>

    <!-- Container for all Content -->
    <!-- Search Container -->
    <div class="container" id="inner-container">
        <form method="GET">
            <h2>Filter</h2>
            <div class="row">
                <?php if (!isset($errors["x"])) : ?>
                    <div class="col-lg-3">
                        <!-- Input X Position -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">X</span>
                            </div>
                            <input name="x" type="text" class="form-control" placeholder="-216" value="<?php echo isset($_GET['x']) ? $_GET['x'] : ""; ?>">
                        </div>
                    </div>

                <?php else : ?>

                    <div class="col-lg-3">
                        <!-- Input X Position -->
                        <div class="form-group">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">X</span>
                                </div>
                                <input name="x" type="text" class="form-control is-invalid" placeholder="-216">
                            </div>
                            <small class="text-danger">
                                <?php echo $errors["x"]; ?>
                            </small>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if (!isset($errors["z"])) : ?>
                    <div class="col-lg-3">
                        <!-- Input Z Position -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Z</span>
                            </div>
                            <input name="z" type="text" class="form-control" placeholder="900" value="<?php echo isset($_GET['z']) ? $_GET['z'] : ""; ?>">
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-lg-3">
                        <!-- Input Z Position -->
                        <div clas="form-group">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Z</span>
                                </div>
                                <input name="z" type="text" class="form-control is-invalid" placeholder="900">
                            </div>
                            <small class="text-danger">
                                <?php echo $errors["z"]; ?>
                            </small>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($errors["world"])) : ?>
                    <div class="col-lg-3">
                        <!-- Droppdown with worlds -->
                        <div class="form-group">
                            <select class="form-control mb-1 is-invalid" name="world">
                                <option value="">Select World</option>
                                <option value="">------------</option>
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
                    <div class="col-lg-3">
                        <!-- Droppdown with worlds -->
                        <div class="form-group">
                            <select class="form-control mb-3" name="world">
                                <option value="">Select World</option>
                                <option value="">------------</option>
                                <?php foreach ($worlds as $w) : ?>
                                    <option <?php echo isset($_GET["world"]) && $_GET["world"] == $w ? "selected" : ""; ?> value="<?php echo $w; ?>"><?php echo $w; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if (isset($errors["category"])) : ?>
                    <div class="col-lg-3">
                        <!-- Droppdown for locations types -->
                        <div class="form-group">
                            <select class="form-control mb-1 is-invalid" name="category">
                                <option value="">Select Category</option>
                                <option value="">------------</option>
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
                    <div class="col-lg-3">
                        <!-- Droppdown for locations types -->
                        <div class="form-group">
                            <select class="form-control mb-3" name="category" value="<?php echo isset($_POST["category"]) ? $_POST["category"] : ""; ?>">
                                <option value="">Select Category</option>
                                <option value="">------------</option>
                                <?php foreach ($categories as $c) : ?>
                                    <option <?php echo isset($_GET["category"]) && $_GET["category"] == $c ? "selected" : ""; ?> value="<?php echo $c; ?>"><?php echo $c; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


            <input type="submit" class="btn btn-light mb-4" value="Search" name="search">
        </form>

        <!--Flöde Point of Interest-->
        <h2>Points of interest</h2>
        <?php foreach ($result as $key => $row) :  ?>
            <div class="card border-dark mb-3 card-coords" style="max-width: 100%;">
                <div class="card-header bg-transparent border-dark">
                    <div class="row">
                        <div class="col-sm-6">
                            <b><?php echo htmlspecialchars($row["name"]); ?></b>
                        </div>
                        <?php if (Auth::isLoggedIn() && Auth::userId() == $row["user_id"]) : ?>
                            <div class="col-sm-6 text-right">
                                <a href="/coords.php?type=edit&id=<?php echo $row["id"] ?>" class="btn btn-dark">Edit</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body text-dark">
                    <h6 class="card-title">X: <?php echo $row["x"]; ?> <?php echo $row["y"] == null ? "" : "Y: " . $row["y"]; ?> Z: <?php echo $row["z"]; ?></h6>
                    <p class="card-text">Description: <?php echo htmlspecialchars($row["description"]); ?></p>
                    <?php if ($row["looted"]) : ?>
                        <p class="card-text">Looted: <i class="fa fa-check-square"></i></p>
                    <?php endif; ?>
                    <?php if (isset($row["distance"])) : ?>
                        <p class="card-text">Distance: <?php echo round($row["distance"]); ?></p>
                    <?php endif; ?>
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