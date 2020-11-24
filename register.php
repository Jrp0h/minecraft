<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="card" style="background-color: rgba(255,255,255,0.8);">
            <div class="card-header">Register</div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="mc_username">Minecraft Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Epic_gamer43">
                    </div>
                    <div class="form-group">
                        <label for="dc_username">Discord Username</label>
                        <input type="text" class="form-control" id="dc_username" name="dc_username" placeholder="Epic_gamer43#6969">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <input type="submit" class="btn btn-dark mt-3" value="Register">
                </form>
            </div>
        </div>
    </div>
    </div>

    <script src="scripts/main.js"></script>
</body>

</html>
