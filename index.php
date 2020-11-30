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
    <!-----------Navbar------------>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <!--Viktigt att lägga <a> före button och diven för att "brand" ska komma till vänster, annars tvärtom om man vil ha "brand" till höger-->
        <a class="navbar-brand" href="">
            <img src="/images/mc.png" width="25" height="25" class="align-top mt-1" alt="" loading="lazy">
            85.24.194.62
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav ml-auto text-right">
                <li class="nav-item"><a class="nav-link" href="/index.php">Home / </a></li>
                <li class="nav-item"><a class="nav-link" href="/coords.php">Add Coords / </a></li>
                <li class="nav-item"><a class="nav-link" href="">Trades / </a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Log in /</a></li>
                <li class="nav-item"><a class="btn btn-light btn-sm mt-1 btn-nav" href="">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="badge badge-light">0</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

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
            <div class="card border-dark mb-3 card-coords" style="max-width: 100%;">
                <div class="card-header bg-transparent border-dark">Name of Location</div>
                <div class="card-body text-dark">
                    <h6 class="card-title">X: Y: Z:</h6>
                    <p class="card-text">Description</p>
                </div>
                <div class="card-footer bg-transparent border-dark">World -- Location Type</div>
            </div>
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


            <!-- <div class="container">
            </div>
            <div class="container">

            </div>
            <div class="container">

            </div>
            <div class="container">

            </div> -->
        </div>

        <script src="scripts/main.js" async defer></script>
</body>

</html>