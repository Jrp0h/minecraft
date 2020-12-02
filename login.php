<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "./includes/database.php";
include_once "./includes/auth.php";
include_once "./includes/notification.php";

if (Auth::isLoggedIn()) {
    header("Location: index.php");
    die();
}

while (isset($_POST["submit"])) {
    $db = new Database();
    $result = $db->query("SELECT * FROM users WHERE mc_username = :username OR dc_username  = :username", ["username" => $_POST["username"]]);

    if (count($result) != 1) {
        Notification::danger("Invalid username/password");
        break;
    }

    $user = $result[0];

    if (!password_verify($_POST["password"], $user["password"])) {
        Notification::danger("Invalid username/password");
        break;
    }

    $_SESSION["user_id"] = $user["id"];
    Notification::info("You've been logged in");
    header("Location: index.php");
    die();
    break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        <div class="container" id="inner-container">
            <h2>Login</h2>

            <form method="POST">
                <div class="form-group">
                    <label for="username">Minecraft or Discord Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Epic_gamer43">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <input type="submit" class="btn btn-light mt-3" value="Login" name="submit">
            </form>
        </div>

    <script src="scripts/main.js"></script>
</body>

</html>
