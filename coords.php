<?php
include_once "./includes/validation.php";
include_once "./includes/database.php";
require_once "./includes/auth.php";

if (!Auth::isLoggedIn()) {
    header("Location: login.php");
    die();
}

$errors = [];

$y = null;

if (isset($_POST["submit"])) {
    if (!isset($_POST["x"]) || !Validator::isNumber($_POST["x"])) {
        $errors["x"] = ("X can´t be empty or non-numeric");
    }
    if (!isset($_POST["z"]) || !Validator::isNumber($_POST["z"])) {
        $errors["z"] = ("Z can´t be empty or non-numeric");
    }
    if (isset($_POST["y"]) && $_POST["y"] != "") {
        $y = $_POST["y"];
        if (!Validator::isNumber($_POST["y"])) {
            $errors["y"] = ("Y can´t be non-numeric");
        }
    }

    if (!isset($_POST["world"]) || !in_array($_POST["world"], ["Overworld", "Nether", "End"])) {
        $errors["world"] = ("You need to choose one of the three options");
    }
    if (!isset($_POST["location"]) || !in_array($_POST["location"], ["Home", "Biome", "Temple", "Spawner", "Misc"])) {
        $errors["location"] = ("You need to choose one of the options");
    }
    if (!isset($_POST["description"]) || $_POST["description"] == "") {
        $errors["description"] = ("You need to put in a description");
    }
    if (!isset($_POST["name"]) || $_POST["name"] == "") {
        $errors["name"] = ("You need to put in a location name");
    }

    $db = new Database();
    if (count($errors) <= 0) {
        $looted = 0;
        if (isset($_POST["looted"])) {
            $looted = intval($_POST["looted"] == "on");
        }
        $db->exec("INSERT INTO points_of_interest (user_id,name,x,y,z,looted,description,location,category) VALUES (:user_id,:name,:x,:y,:z,:looted,:description,:location,:category)", ["user_id" => 8, "name" => $_POST["name"], "x" => $_POST["x"], "y" => $y, "z" => $_POST["z"], "description" => $_POST["description"], "looted" => $looted, "location" => $_POST["world"], "category" => $_POST["location"]]);
    }
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


        <div class="container" id="inner-container">
            <h2>Add Point of Interest</h2>
            <form method="POST" action="#">
                <div class="row">

                    <!--PHP if X sats-->
                    <?php if (isset($errors["x"])) : ?>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <!-- Input X Position -->
                                <div class="input-group mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">X</span>
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
                                    <span class="input-group-text" id="inputGroup-sizing-default">X</span>
                                </div>
                                <input type="text" class="form-control" placeholder="-216" value="<?php echo isset($_POST["x"]) ? $_POST["x"] : ""; ?>" name="x">
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
                                        <span class="input-group-text" id="inputGroup-sizing-default">Y</span>
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
                                        <span class="input-group-text" id="inputGroup-sizing-default">Y</span>
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo isset($_POST["y"]) ? $_POST["y"] : ""; ?>" placeholder="76" name="y">
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
                                        <span class="input-group-text" id="inputGroup-sizing-default">Z</span>
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
                                        <span class="input-group-text" id="inputGroup-sizing-default">Z</span>
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo isset($_POST["z"]) ? $_POST["z"] : ""; ?>" placeholder="900" name="z">
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
                                    <option value="Overworld">Overworld</option>
                                    <option value="Nether">Nether</option>
                                    <option value="End">End</option>
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
                                    <option value="Overworld">Overworld</option>
                                    <option value="Nether">Nether</option>
                                    <option value="End">End</option>
                                </select>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if (isset($errors["location"])) : ?>
                        <div class="col-lg-6">
                            <!-- Droppdown for locations types -->
                            <div class="form-group">
                                <select class="form-control mb-1 is-invalid" name="location">
                                    <option>Select Location Type</option>
                                    <option>------------</option>
                                    <option value="Home">Home</option>
                                    <option value="Biome">Biome</option>
                                    <option value="Spawner">Spawner</option>
                                    <option value="Temple">Temple</option>
                                    <option value="Misc">Misc</option>
                                </select>
                                <small class="text-danger">
                                    <?php echo $errors["location"]; ?>
                                </small>
                            </div>
                        </div>
                    <?php else : ?>


                        <div class="col-lg-6">
                            <!-- Droppdown for locations types -->
                            <div class="form-group">
                                <select class="form-control mb-3" name="location">
                                    <option>Select Location Type</option>
                                    <option>------------</option>
                                    <option value="Home">Home</option>
                                    <option value="Biome">Biome</option>
                                    <option value="Spawner">Spawner</option>
                                    <option value="Temple">Temple</option>
                                    <option value="Misc">Misc</option>
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
                                        <span class="input-group-text" id="inputGroup-sizing-default">Name of location</span>
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
                                        <span class="input-group-text" id="inputGroup-sizing-default">Name of location</span>
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ""; ?>" placeholder="Marqus house" name="name">
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
                                        <span class="input-group-text" id="inputGroup-sizing-default">Description</span>
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
                                        <span class="input-group-text" id="inputGroup-sizing-default">Description</span>
                                    </div>
                                    <textarea class="form-control" rows="5" name="description"><?php echo isset($_POST["description"]) ? $_POST["description"] : ""; ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>


                </div>
                <!-- Looted -->
                <div>
                    <input type="checkbox" class="form-check-input ml-1" name="looted">
                    <label class="form-check-label ml-4">Looted</label>
                </div>
                <!--Button-->
                <div>

                    <input type="submit" class="btn btn-light mt-3" value="Add" name="submit">
                </div>
            </form>
        </div>
    </div>

    <script src="scripts/main.js"></script>
</body>

</html>