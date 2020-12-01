<?php
include_once "./includes/validation.php";
include_once "./includes/database.php";

$db = new Database();
$result = $db->query("SELECT * FROM points_of_interest");
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
    <div class="container mt-2">

        <!-- Search Container -->
        <div class="container" id="inner-container">
            <h2>Filter</h2>
            <div class="row">
                <div class="col-lg-4">
                    <!-- Input X Position -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">X</span>
                        </div>
                        <input type="text" class="form-control" placeholder="-216" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Input Y Position -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Y</span>
                        </div>
                        <input type="text" class="form-control" placeholder="76" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Input Z Position -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Z</span>
                        </div>
                        <input type="text" class="form-control" placeholder="900" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <!-- Droppdown with worlds -->
                    <select class="form-control mb-3">
                        <option>Select World</option>
                        <option>------------</option>
                        <option>Overworld</option>
                        <option>Nether</option>
                        <option>End</option>
                    </select>
                </div>
                <div class="col-lg-6">
                    <!-- Droppdown for locations types -->
                    <select class="form-control mb-3">
                        <option>Select Location Type</option>
                        <option>------------</option>
                        <option>Home</option>
                        <option>Biom</option>
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
                    <div class="card-header bg-transparent border-dark"><?php echo $row["name"]; ?></div>
                    <div class="card-body text-dark">
                        <h6 class="card-title">X: <?php echo $row["x"]; ?> Y: <?php echo $row["y"]; ?> Z: <?php echo $row["z"]; ?></h6>
                        <p class="card-text">Description: <?php echo $row["description"]; ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-dark"><?php echo $row["location"]; ?> -- <?php echo $row["category"]; ?></div>
                </div>
            <?php endforeach; ?>
            <!-- 
                      <div class="card border-dark mb-3 card-coords " style="max-width: 100%;">
                        <div class="card-header bg-transparent border-dark">Name of Location</div>
                        <div class="card-body text-dark">
                          <h6 class="card-title">X: Y: Z:</h6>
                          <p class="card-text">Description</p>
                        </div>
                        <div class="card-footer bg-transparent border-dark">World -- Location Type</div>
                      </div>

                    <div class="card border-dark mb-3 card-coords" style="max-width: 100%;">
                        <div class="card-header bg-transparent border-dark">Name of Location</div>
                        <div class="card-body text-dark">
                          <h6 class="card-title">X: Y: Z:</h6>
                          <p class="card-text">Description</p>
                        </div>
                        <div class="card-footer bg-transparent border-dark">World -- Location Type</div>
                      </div> -->
            <!-- </div> -->
        </div>

        <script src="scripts/main.js" async defer></script>
</body>

</html>