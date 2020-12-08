<?php
include_once "./includes/cart.php";



if (isset($_POST["minus"])) {
    Cart::remove(intval($_POST["id"]));
}
if (isset($_POST["plus"])) {
    Cart::add(intval($_POST["id"]));
}
if (isset($_POST["clear"])) {
    Cart::clear();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <style>
        .side-by-side {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .side-by-side p {
            margin: 0 1rem;
        }

        th,
        td {
            color: white;
        }
    </style>
    <link rel="stylesheet" href="/styles/style.css">
    <!--FontAwsome link-->
    <link rel="stylesheet" href="styles/font-awesome-4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php require('navbar.php'); ?>

    <?php require('notifications.php'); ?>

    <div class="container" id="inner-container">
        <h2>Cart</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th>Total</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (Cart::returnAll() as $item) : ?>
                    <tr>
                        <td><?php echo $item["name"] ?></td>
                        <td>
                            <div class="side-by-side">
                                <img src="/images/items/emerald.png" width="20" height="20">
                                <p><?php echo $item["price"] ?></p>
                            </div>
                        </td>
                        <td>
                            <form method="POST">
                                <div class="side-by-side">
                                    <input type="submit" name="minus" value="-" class="btn btn-light">
                                    <input type="hidden" name="id" value="<?php echo $item["id"] ?>">
                                    <p><?php echo $item["amount"] ?></p>
                                    <input type="submit" name="plus" value="+" class="btn btn-light">
                                </div>
                            </form>
                        </td>
                        <td>
                            <div class="side-by-side">
                                <img src="/images/items/emerald.png" width="20" height="20">
                                <p><?php echo $item["total_price"] ?></p>
                            </div>
                        </td>
                        <td><?php echo $item["poi_name"] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <hr>

        <p>Total Price:</p>
        <form method="POST">
            <div class="row">
                <div class=" col-sm-6">
                    <div class="side-by-side">
                        <div class="side-by-side">
                            <img src="/images/items/emerald.png" width="20" height="20">
                            <b style="margin-left: 0.5rem;"> <?php echo Cart::returnPrice(); ?> </b>
                        </div>
                        <p style="margin: 0px 0.5rem;">and</p>
                        <div class="side-by-side">
                            <img src="/images/items/book.png" width="20" height="20">
                            <b style="margin-left: 0.5rem;"> <?php echo Cart::totalAmount(); ?> </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 text-right mb-2">
                    <input type="submit" class="btn btn-light" value="Clear Cart" name="clear">
                </div>
            </div>
        </form>
    </div>
    <script src="scripts/main.js"></script>
</body>

</html>