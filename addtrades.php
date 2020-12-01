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
    <div class="conatiner">
        <div class="container" id="inner-container">
            <h2>Add Emerald Trades</h2>
            <p><b>Put in what trades your villagers have to offer, only trades where you get emeralds</b></p>
            <div class="row">
                <!-- Droppdown for locations types -->
                <select class="col-lg-12 form-control m-3 ">
                    <option>Select where to find</option>
                    <option>------------</option>
                    <option>Marcus Home</option>
                    <option>Fannie´s Home</option>
                </select>
            </div>
            <div class="row">

                <div class="col-lg-4">
                    <!-- Input Item -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Item</span>
                        </div>
                        <input type="text" class="form-control" placeholder="String" aria-label="Default"
                            aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Input Item -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Secondary Item</span>
                        </div>
                        <input type="text" class="form-control" placeholder="" aria-label="Default"
                            aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Input Emeralds -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">
                                <img src="/images/emerald.png" width="20" height="20">
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="How many emeralds you get"
                            aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
            </div>

            <!--Button-->
            <div>
                <button class="btn btn-light">Add</button>
            </div>
        </div>
    </div>

    <div class="conatiner">
        <div class="container" id="inner-container">
            <h2>Add Enchantments</h2>
            <p><b>Put in what enchantments your villagers have to offer</b></p>
            <div class="row">
                <!-- Droppdown for locations types -->
                <select class="col-lg-12 form-control m-3 ">
                    <option>Select where to find</option>
                    <option>------------</option>
                    <option>Marcus Home</option>
                    <option>Fannie´s Home</option>
                </select>
            </div>
            <div class="row">

                <div class="col-lg-6">
                    <!-- Input Enchantment -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Enchantment</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Sharpness V" aria-label="Default"
                            aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- Input Emeralds -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">
                                <img src="/images/emerald.png" width="20" height="20">
                            </span>
                        </div>
                        <input type="text" class="form-control" placeholder="How many emeralds it costs"
                            aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
            </div>

            <!--Button-->
            <div>
                <button class="btn btn-light">Add</button>
            </div>
        </div>
    </div>

    <script src="scripts/main.js"></script>
</body>

</html>