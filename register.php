<?php
require_once "./includes/validation.php";
require_once "./includes/database.php";
require_once "./includes/auth.php";
require_once "./includes/notification.php";

if (Auth::isLoggedIn()) {
    header("Location: index.php");
    die();
}

$errors = [];

if (isset($_POST["submit"])) {
    if (isset($_POST["mc_username"])) {
        if ($_POST["mc_username"] == "" || !Validator::matchesRegex($_POST['mc_username'], "/^[a-zA-Z_\d]{3,16}+$/m")) {
            $errors["mc_username"] = "Invalid minecraft username";
        } else {
            $db = new Database();

            $result = $db->query(
                "SELECT mc_username FROM users WHERE mc_username = :mc_username", 
                ["mc_username" => $_POST["mc_username"]]
            );

            if (count($result) > 0) {
                $errors["mc_username"] = "That minecraft username is already registered";
            }
        }
    } else {
        $errors["mc_username"] = "You need to enter your minecraft username";
    }

    if (isset($_POST["dc_username"])) {
        if ($_POST["dc_username"] == "" || !Validator::matchesRegex($_POST["dc_username"], "/^.+#\d{4}$/m")) {
            $errors["dc_username"] = "Invalid discord username";
        } else {
            $db = new Database();
            
            $result = $db->query(
                "SELECT dc_username FROM users WHERE dc_username = :dc_username",
                ["dc_username" => $_POST["dc_username"]]
            );

            if (count($result) > 0) {
                $errors["dc_username"] = "That discord username is already registered";
            }
        }
    } else {
        $errors["dc_username"] = "You need to write your discord username";
    }

    if (!isset($_POST["password"]) || $_POST["password"] == "" || !Validator::matchesRegex($_POST["password"], "/[A-Z]/m") || !Validator::matchesRegex($_POST["password"], "/\d/m") || !Validator::matchesRegex($_POST["password"], "/^\S{8,}$/m")) {
        $errors["password"] = "Password must contain at least 8 Characters (At least 1 uppercase and 1 number)";
    }

    $db = new Database();
    if (count($errors) <= 0) {

        $db->exec(
            "INSERT INTO users (dc_username, mc_username, password) VALUES (:dc_username, :mc_username, :password)",
            [
                "dc_username" => $_POST["dc_username"],
                "mc_username" => $_POST["mc_username"],
                "password" => password_hash($_POST["password"], PASSWORD_BCRYPT)
            ]
        );

        Notification::success("You've been registered successfully, you can now sign in");
        header("Location: login.php");
        die();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
                <h2>Register</h2>
                <form action="register.php" method="POST">
                    <?php if (isset($errors["mc_username"])) : ?>
                        <div class="form-group">
                            <label for="mc_username">Minecraft Username</label>
                            <input type="text" class="form-control is-invalid" id="username" name="mc_username" placeholder="Epic_gamer43">
                            <small class="text-danger">
                                <?php echo $errors["mc_username"]; ?>
                            </small>
                        </div>

                    <?php else : ?>

                        <div class="form-group">
                            <label for="mc_username">Minecraft Username</label>
                            <input type="text" class="form-control" id="username" value="<?php echo isset($_POST["mc_username"]) ? $_POST["mc_username"] : ""; ?>" name="mc_username" placeholder="Epic_gamer43">
                        </div>

                    <?php endif; ?>


                    <?php if (isset($errors["dc_username"])) : ?>
                        <div class="form-group">

                            <label for="dc_username">Discord Username</label>
                            <input type="text" class="form-control is-invalid" id="dc_username" name="dc_username" placeholder="Epic_gamer43#6969">
                            <small class="text-danger">
                                <?php echo $errors["dc_username"]; ?>
                            </small>
                        </div>

                    <?php else : ?>

                        <div class="form-group">
                            <label for="dc_username">Discord Username</label>
                            <input type="text" class="form-control" id="dc_username" value="<?php echo isset($_POST["dc_username"]) ? $_POST["dc_username"] : ""; ?>" name="dc_username" placeholder="Epic_gamer43#6969">
                        </div>

                    <?php endif; ?>

                    <?php if (isset($errors["password"])) : ?>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control is-invalid" id="password" name="password" placeholder="Password">
                            <small class="text-danger">
                                <?php echo $errors["password"]; ?>
                            </small>
                        </div>
                    <?php else : ?>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            <small style="color: rgb(200, 200, 200);">
                                Must contain at least 8 Characters (At least 1 uppercase and 1 number)
                            </small>
                        </div>
                    <?php endif; ?>

                    <input type="submit" name="submit" class="btn btn-light mt-3" value="Register">
                </form>
        </div>

    <script src="scripts/main.js"></script>
</body>

</html>
