<?php
include_once "./includes/database.php";
include_once "./includes/notification.php";

if(!isset($_GET["id"]))
{
	Notification::danger("Invalid ID");
	header("Location: index.php");
	die();
}

$db = new Database();
$result = $db->query("SELECT * FROM points_of_interest WHERE id = :id", ["id" => $_GET["id"]]);

if(count($result) <= 0)
{
	Notification::danger("Invalid ID");
	header("Location: index.php");
	die();
}

$poi = $result[0];

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
        <!--Flöde Point of Interest-->
		<h2>Point of Interest</h2>
            <div class="card border-dark mb-3 card-coords" style="max-width: 100%;">
                <div class="card-header bg-transparent border-dark">
                    <div class="row">
                        <div class="col-sm-6">
                            <b><?php echo htmlspecialchars($poi["name"]); ?></b>
                        </div>
                        <?php if (Auth::isLoggedIn() && Auth::userId() == $poi["user_id"]) : ?>
                            <div class="col-sm-6 text-right">
                                <a href="/coords.php?type=edit&id=<?php echo $poi["id"] ?>" class="btn btn-dark">Edit</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body text-dark">
                    <h6 class="card-title">X: <?php echo $poi["x"]; ?> <?php echo $poi["y"] == null ? "" : "Y: " . $poi["y"]; ?> Z: <?php echo $poi["z"]; ?></h6>
                    <p class="card-text">Description: <?php echo htmlspecialchars($poi["description"]); ?></p>
                    <?php if ($poi["looted"]) : ?>
                        <p class="card-text">Looted: <i class="fa fa-check-square"></i></p>
                    <?php endif; ?>
                    <?php if (isset($poi["distance"])) : ?>
                        <p class="card-text">Distance: <?php echo round($poi["distance"]); ?></p>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-transparent border-dark">
                    <div class="row">
                        <div class="col">
                            <?php echo $poi["world"]; ?> -- <?php echo $poi["category"]; ?>
                        </div>
                        <div class="col text-right">
                            <?php echo $poi["user_mc_username"] . "/" . $poi["user_dc_username"]; ?>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <script src="scripts/main.js" async defer></script>
</body>

</html>
