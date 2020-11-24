<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Calculator</div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <input type="text" class="form-control" id="x" placeholder="X">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <input type="text" class="form-control" id="y" placeholder="Y">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <input type="text" class="form-control" id="z" placeholder="Z">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <select class="form-control">
                                <option>Overworld to Nether</option>
                                <option>Nether to Overworld</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary mt-3" value="Calculate">

                    <div id="result-container">
                        <hr>
                        <h3>Result</h3>
                        <p>
                            <b id="resX">X</b>
                            <b id="resY">Y</b>
                            <b id="resZ">Z</b>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
