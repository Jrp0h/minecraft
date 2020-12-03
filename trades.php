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

    <?php require('navbar.php'); ?>

    <?php require('notifications.php'); ?>

    <!-- Container for all Content -->
    <div class="container" id="inner-container">
        <!--Flöde Enchantments-->
        <h2>Enchantments</h2>
        <div class="card border-dark mb-2 pt-3 card-coords">
            <div class="card-body bg-transparent border-dark">
                <div class="row">
                    <div class="col-lg-2 pt-3">
                        <h6>Looting II</h6>
                    </div>
                    <div class="col-lg-3 text-center">
                        <img src="/images/items/emerald.png" width="20" height="20">
                        <p>12</p>
                    </div>
                    <div class="col-lg-1 pt-1">
                        <h6>+</h6>
                    </div>
                    <div class="col-lg-3 text-center">
                        <img src="/images/items/book.png" width="20" height="20">
                        <p>1</p>
                    </div>
                    <div class="col-lg-3 text-right pt-2">
                        <a href="" class="btn btn-dark" value="addToCart">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="card border-dark mb-3 card-coords">
                    <div class="card-body bg-transparent border-dark">
                        <p>Looting II</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card border-dark mb-3 card-coords">
                    <div class="card-body bg-transparent border-dark">
                        <p>Looting II</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="card border-dark mb-3 card-coords">
                    <div class="card-body bg-transparent border-dark">
                        <p>Looting II</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="card border-dark mb-3 card-coords">
                    <div class="card-body bg-transparent border-dark">
                        <p>Looting II</p>
                    </div>

                </div>
            </div>
        </div>

    </div>




    <script src="scripts/main.js" async defer></script>
</body>

</html>