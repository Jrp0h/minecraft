<?php
include_once "./includes/validation.php";
include_once "./includes/database.php";
require_once "./includes/auth.php";
require_once "./includes/notification.php";
require_once "./includes/cart.php";

if (!Auth::isLoggedIn()) {
    Notification::warning("You must be logged in too look at trades");
    header("Location: login.php");
    die();
}

$db = new Database();

if (isset($_POST["submit"])) {
    Cart::add($_POST["id"]);
}

if (isset($_POST["delete"])) {
    if (isset($_POST["type"]) && $_POST["type"] == "enchantment") {
        if (isset($_POST["id"])) {
            $result = $db->query("SELECT user_id FROM enchantments WHERE id=:id", ["id" => $_POST["id"]]);
            if (count($result) > 0) {
                if (Auth::userId() == $result[0]["user_id"]) {
                    $db->exec("DELETE FROM enchantments WHERE id = :id;", ["id" => $_POST["id"]]);
                }
            }
        }
    } else if (isset($_POST["type"]) && $_POST["type"] == "trade") {
        if (isset($_POST["id"])) {
            $result = $db->query("SELECT user_id FROM trades WHERE id=:id", ["id" => $_POST["id"]]);
            if (count($result) > 0) {
                if (Auth::userId() == $result[0]["user_id"]) {
                    $db->exec("DELETE FROM trades WHERE id = :id;", ["id" => $_POST["id"]]);
                }
            }
        }
    }
}
$enchantments = $db->query("SELECT enchantments.*, points_of_interest.name AS poi_name FROM enchantments INNER JOIN points_of_interest ON enchantments.poi_id = points_of_interest.id");
$trades = $db->query("SELECT trades.*, trades.item_id AS first_item_id, trades.item_amount AS first_item_amount, i1.name AS first_item_name, i1.image_url AS first_item_image_url, i2.name AS secondary_item_name, i2.image_url AS secondary_item_image_url, i3.name AS return_item_name, i3.image_url AS return_item_image_url, points_of_interest.name AS poi_name FROM trades LEFT JOIN items i1 ON trades.item_id = i1.id LEFT JOIN items i2 ON trades.secondary_item_id = i2.id LEFT JOIN items i3 ON trades.return_item_id = i3.id INNER JOIN points_of_interest ON trades.poi_id = points_of_interest.id;");
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
    <style>
        .side-by-side {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .side-by-side p {
            margin: 0 1rem;
        }

        th,
        td {
            color: white;
        }
    </style>
</head>

<body>

    <?php require('navbar.php'); ?>

    <?php require('notifications.php'); ?>

    <!-- Container for all Content -->
    <div id="accordion">
        <div class="container" id="inner-container">
            <div id="headingOne">
                <div class="row collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <div class="col-sm-6">
                        <h2>Enchantments <i class="fa fa-sort-down"></i></h2>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="/addtrades.php?group=enchantment" class="btn btn-light">Add Enchantment</a>
                    </div>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="custom-grid">

                            <?php foreach ($enchantments as $e) : ?>
                                <div class="card border-dark card-coords" style="max-width: 100%;">
                                    <div class="card-header bg-transparent border-dark">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <b><?php echo htmlspecialchars($e["name"]); ?></b>
                                            </div>
                                            <?php if (Auth::isLoggedIn() && Auth::userId() == $e["user_id"]) : ?>
                                                <div class="col-sm-4 text-right">
                                                    <form method="POST">
                                                        <input class="btn btn-danger pb-0 pt-0" value="Delete" type="submit" name="delete">
                                                        <input type="hidden" value="<?php echo $e["id"] ?>" name="id">
                                                        <input type="hidden" value="enchantment" name="type">
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card-body text-dark">
                                        <div class="card-title">
                                            <div class="side-by-side">
                                                <div class="side-by-side">
                                                    <img src="/images/items/emerald.png" width="20" height="20">
                                                    <b style="margin-left: 0.5rem;"><?php echo $e["price"]; ?></b>
                                                </div>
                                                <p style="margin: 0px 0.5rem;">and</p>
                                                <div class="side-by-side">
                                                    <img src="/images/items/book.png" width="20" height="20">
                                                    <b style="margin-left: 0.5rem;">1</b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-text">
                                            Located: <a href="/poi.php?id=<?php echo $e["poi_id"]; ?>"><?php echo htmlspecialchars($e["poi_name"]); ?></a>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-dark">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button class="btn btn-dark" onclick="addToCart(<?php echo $e['id']; ?>)">Add to Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container" id="inner-container">
            <div id="headingTwo">
                <div class="row collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <div class="col-sm-6">
                        <h2>Trades <i class="fa fa-sort-down"></i></h2>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="/addtrades.php?group=trade" class="btn btn-light">Add Trade</a>
                    </div>
                </div>
            </div>

            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <div class="custom-grid">

                        <!-- for test -->
                        <?php foreach ($trades as $t) : ?>
                            <div class="card border-dark card-coords" style="max-width: 100%;">
                                <div class="card-body text-dark">
                                    <div class="side-by-side">
                                        <p style="margin: 0px 0.5rem 0px 0px;">Give:</p>
                                        <div class="side-by-side">
                                            <img src="<?php echo $t["first_item_image_url"]; ?>" width="20" height="20">
                                            <b style="margin-left: 0.5rem;"><?php echo $t["first_item_amount"]; ?></b>
                                        </div>
                                        <?php if ($t["secondary_item_id"] != null) : ?>
                                            <p style="margin: 0px 0.5rem;">and</p>
                                            <div class="side-by-side">
                                                <img src="<?php echo $t["secondary_item_image_url"] ?>" width="20" height="20">
                                                <b style="margin-left: 0.5rem;"><?php echo $t["secondary_item_amount"]; ?></b>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="side-by-side">
                                        <p style="margin: 0px 0.5rem 0px 0px;">Get:</p>
                                        <div class="side-by-side">
                                            <img src="<?php echo $t["return_item_image_url"]; ?>" width="20" height="20">
                                            <b style="margin-left: 0.5rem;"><?php echo $t["return_item_amount"]; ?></b>
                                        </div>
                                    </div>
                                    <div class="card-text">
                                            Located: <a href="/poi.php?id=<?php echo $t["poi_id"]; ?>"><?php echo htmlspecialchars($t["poi_name"]); ?></a>
                                    </div>
                                    <?php if (Auth::isLoggedIn() && Auth::userId() == $t["user_id"]) : ?>
                                        <form method="POST">
                                            <input class="btn btn-danger pb-0 pt-0" value="Delete" type="submit" name="delete">
                                            <input type="hidden" value="<?php echo $t["id"] ?>" name="id">
                                            <input type="hidden" value="trade" name="type">
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!--Flöde Enchantments-->





    <script src="scripts/main.js" async defer></script>
</body>

</html>
