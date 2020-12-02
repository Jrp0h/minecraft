<?php
include_once "./includes/validation.php";
include_once "./includes/database.php";

$db = new Database();
$result = $db->query("SELECT poi.*, users.dc_username AS user_dc_username, users.mc_username AS user_mc_username
FROM points_of_interest AS poi
INNER JOIN users
ON poi.user_id = users.id
ORDER BY poi.created_at DESC;");


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
	SQRT(((x - :x)*(x - :x) + (z - :z)*(z - :z))) AS distance
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
	SQRT(((x - :x)*(x - :x) + (z - :z)*(z - :z))) AS distance
	FROM points_of_interest 
	INNER JOIN users 
	ON points_of_interest.user_id = users.id
	WHERE world = :world
    AND category = :category
    ORDER BY distance;",
];

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
        <h2>Filter</h2>
        <div class="row">
            <div class="col-lg-3">
                <!-- Input X Position -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">X</span>
                    </div>
                    <input type="text" class="form-control" placeholder="-216">
                </div>
            </div>

            <div class="col-lg-3">
                <!-- Input Z Position -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Z</span>
                    </div>
                    <input type="text" class="form-control" placeholder="900">
                </div>
            </div>
            <div class="col-lg-3">
                <!-- Droppdown with worlds -->
                <select class="form-control mb-3">
                    <option>Select World</option>
                    <option>------------</option>
                    <option>Overworld</option>
                    <option>Nether</option>
                    <option>End</option>
                </select>
            </div>
            <div class="col-lg-3">
                <!-- Droppdown for locations types -->
                <select class="form-control mb-3">
                    <option>Select Category</option>
                    <option>------------</option>
                    <option>Home</option>
                    <option>Biome</option>
                    <option>Spawner</option>
                    <option>Temple</option>
                    <option>Misc</option>
                </select>
            </div>
        </div>

        <button class="btn btn-light mb-4" type="button">Search</button>

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
