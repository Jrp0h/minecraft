<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "./includes/database.php";
$errors = false;

while (isset($_POST["submit"])) {
    $db = new Database();
    $save = $db->query("SELECT * FROM users WHERE mc_username = :username OR dc_username  = :username", ["username" => $_POST["username"]]);
    if (count($save) != 1) {
        $errors = true;
        break;
    }
    $save = $save[0];

    if (!password_verify($_POST["password"], $save["password"])) {
        $errors = true;
        break;
    }
    $_SESSION["user_id"] = $save["id"];
    header("Location: index.php");
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


    <div class="container">
        <div class="card" id="inner-container">
            <div class="card-header">
                <h2>Login</h2>
            </div>
            <div class="card-body">
                <?php if ($errors) : ?>
                    <p class="text-danger">
                        Invalid password/username
                    </p>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Minecraft or Discord Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Epic_gamer43">
                    </div>
                    <div class="form-group">
                        <label for="paord">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <input type="submit" class="btn btn-light mt-3" value="Login" name="submit">
                </form>
            </div>
        </div>
    </div>

    <script src="scripts/main.js"></script>
</body>

</html>