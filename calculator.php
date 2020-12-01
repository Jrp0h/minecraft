<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
        </script>
    <link rel="stylesheet" href="/styles/style.css">
    <!--FontAwsome link-->
    <link rel="stylesheet" href="styles/font-awesome-4.7.0/css/font-awesome.min.css">
</head>

<body>

    <?php require('navbar.php'); ?>



    <!-- <div class="container mt-2"> -->
    <div class="container" id="inner-container">
        <h2>Calculator</h2>
        <form id="calculateForm">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Input X Position -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">X</span>
                        </div>
                        <input type="text" id="x" class="form-control" placeholder="-216">
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Input X Position -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Y</span>
                        </div>
                        <input type="text" id="y" class="form-control" placeholder="-216">
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Input X Position -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Z</span>
                        </div>
                        <input type="text" id="z" class="form-control" placeholder="-216">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <select class="form-control" id="option">
                        <option value="otn">Overworld to Nether</option>
                        <option value="nto">Nether to Overworld</option>
                    </select>
                </div>
            </div>
            <input type="submit" class="btn btn-light mt-3" value="Calculate">

            <div id="result-container">
                <hr>
                <h2>Result</h2>
                <p>
                    <b>X:</b>
                    <i id="resX">X</i>

                    <b>Y:</b>
                    <i id="resY">y</i>

                    <b>Z:</b>
                    <i id="resZ"></i>
                </p>
            </div>
        </form>
    </div>
    <!-- </div> -->

    <script src="scripts/calculator.js"></script>
    <script src="scripts/main.js"></script>
</body>

</html>
