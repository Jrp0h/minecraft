
<?php
    include_once "./includes/validation.php";
    include_once "./includes/database.php";
    require_once "./includes/auth.php";
    require_once "./includes/notification.php";

    // if (!Auth::isLoggedIn()) {
        // Notification::warning("You must be logged in too add trades");
        // header("Location: login.php");
        // die();
    // }

    $db = new Database();
    // $locations = $db->query("SELECT * FROM points_of_interest WHERE world='Overworld'");
    $items = $db->query("SELECT * FROM items ORDER BY name");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add</title>
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

<div class="container">
    <select class="form-control" name="category" data-custom-dropdown data-custom-dropdown-data="<?php echo base64_encode(json_encode($items)); ?>">
        <option value="">Select Category</option>
    </select>
</div>

    <div id="dd" class="custom-dropdown">
        <div class="custom-dropdown-search">
            <input type="text" class="form-control" id="dd-search">
        </div>
        <hr>
        <div class="custom-dropdown-items" id="dd-items">
                <div class="custom-dropdown-item-group">
                    <img src="" alt="" class="custom-dropdown-item-img">
                    <p class="custom-dropdown-item-title"></p>
                </div>
        </div>    
    </div>

    <script src="/scripts/main.js"></script>
</body>

</html>
