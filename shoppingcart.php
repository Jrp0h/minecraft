<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
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
</head>

<body>
    <div class="container">
        <div class="card" id="inner-container">
            <div class="card-header">
                <h2>Cart</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mending</td>
                            <td>
                                <div class="side-by-side">
                                    <img src="/images/emerald.png" width="20" height="20">
                                    <p>12</p>
                                </div>
                            </td>
                            <td>
                                <div class="side-by-side">
                                    <button class="btn btn-light">
                                        -
                                    </button>
                                    <p>2</p>
                                    <button class="btn btn-light">
                                        +
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="side-by-side">
                                    <img src="/images/emerald.png" width="20" height="20">
                                    <p>24</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Efficiency V</td>
                            <td>
                                <div class="side-by-side">
                                    <img src="/images/emerald.png" width="20" height="20">
                                    <p>64</p>
                                </div>
                            </td>
                            <td>
                                <div class="side-by-side">
                                    <button class="btn btn-light">
                                        -
                                    </button>
                                    <p>1</p>
                                    <button class="btn btn-light">
                                        +
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="side-by-side">
                                    <img src="/images/emerald.png" width="20" height="20">
                                    <p>64</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr>

                <p>Total Price: <div class="side-by-side">
                        <img src="/images/emerald.png" width="20" height="20">
                        <b style="margin-left: 0.5rem;">88</b>
                    </div>
                </p>
            </div>
        </div>
    </div>

    <script src="scripts/main.js"></script>
</body>

</html>