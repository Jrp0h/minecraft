<?php
    include_once "./includes/validation.php";
    include_once "./includes/database.php";

    if(isset($_POST["submit"])){
        if(!isset($_POST["x"])||!Validator::isNumber($_POST["x"])){
            die("x can´t be empty, can´t be non-numeric");
        }
        if(!isset($_POST["z"])||!Validator::isNumber($_POST["z"])){
            die("z can´t be empty, can´t be non-numeric");
        }
        if(isset($_POST["y"])){
            if(!Validator::isNumber($_POST["y"])) {
                die("y can´t be non-numeric");
            }
        }

        if(!isset($_POST["world"])||!in_array($_POST["world"],["Overworld", "Nether", "End"])){
            die("You need to choose one of the three options");
        }
        if(!isset($_POST["location"])||!in_array($_POST["location"],["Home", "Biome", "Temple","Spawner", "Misc"])){
            die("You need to choose one of the options");
        }
        if(!isset($_POST["description"])){
            die("You need to put in a description");
        }
        if(!isset($_POST["name"])){
            die("You need to put in a location name");
        }

        $db = new Database();

        $db->exec("INSERT INTO points_of_interest (user_id,name,x,y,z,image_url,description,location,category) VALUES (:user_id,:name,:x,:y,:z,:image_url,:description,:location,:category)",["user_id"=>1,"name"=>$_POST["name"],"x"=>$_POST["x"],"y"=>$_POST["y"],"z"=>$_POST["z"],"description"=>$_POST["description"], "image_url"=> "jjjjj", "location" => $_POST["world"], "category" => $_POST["location"]]);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="/styles/style.css">
</head>

<body>
    <div class="container" id="inner-container">
        <h2>Add Point of Interest</h2>
        <form method="POST" action="#">
        <div class="row">
            <div class="col-lg-4">
                <!-- Input X Position -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend" >
                        <span class="input-group-text" id="inputGroup-sizing-default">X</span>
                    </div>
                    <input type="text" class="form-control" placeholder="-216" name="x">
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Input Y Position -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Y</span>
                    </div>
                    <input type="text" class="form-control" placeholder="76" name="y">
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Input Z Position -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Z</span>
                    </div>
                    <input type="text" class="form-control" placeholder="900" name="z">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <!-- Droppdown with worlds -->
                <select class="form-control mb-3" name="world">
                    <option>Select World</option>
                    <option>------------</option>
                    <option value="Overworld">Overworld</option>
                    <option value="Nether">Nether</option>
                    <option value="End">End</option>
                </select>
            </div>
            <div class="col-lg-6">
                <!-- Droppdown for locations types -->
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

        <div class="row">
            <div class="col-lg-6">
                <!-- Name of Location -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Name of location</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Marqus house" name="name">
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Image -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Image</span>
                    </div>
                    <input type="file" class="form-control" placeholder="img" name="img">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Description -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Description</span>
                    </div>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="description"></textarea>
                </div>
            </div>
        </div>
        <!--Button-->
        <div>
            <input type="submit" class="btn btn-light" value="Add" name="submit">
        </div>
    </form>
    </div>

    <script src="scripts/main.js"></script>
</body>

</html>