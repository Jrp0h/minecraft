    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once "./includes/auth.php";

    ?>
    <!-----------Navbar------------>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <!--Viktigt att lägga <a> före button och diven för att "brand" ska komma till vänster, annars tvärtom om man vil ha "brand" till höger-->
        <a class="navbar-brand" href="/index.php">
            <img src="/images/mc.png" width="25" height="25" class="align-top mt-1" alt="" loading="lazy">
            85.24.194.62
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav ml-auto text-right">
                <li class="nav-item"><a class="nav-link" href="index.php">Home / </a></li>
                <li class="nav-item"><a class="nav-link" href="">Trades / </a></li>
                <li class="nav-item"><a class="nav-link" href="calculator.php">Calculator / </a></li>
                <?php if (!Auth::isLoggedIn()) : ?>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register /</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Log in / </a></li>
                <?php else : ?>
                    <li class="nav-item"><a class="nav-link" href="coords.php">Add Coords / </a></li>
                    <li class="nav-item"><a class="nav-link" href="signout.php">Sign Out / </a></li>
                    <li class="nav-item"><a class="btn btn-light btn-sm mt-1 btn-nav" href="">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="badge badge-light">0</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>