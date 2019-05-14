<!doctype html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="aryx">
    <title>miniCloud</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <link href="css/minicloud.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top">
    <a class="navbar-brand" href="#">miniCloud</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php"><i class="fas fa-file"></i> My Files</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=shares"><i class="fas fa-share"></i> Shares</a>
            </li>
        </ul>

        <ul class="navbar-nav my-2 my-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i> aryx</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="#"><i class="fas fa-wrench fa-fw"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="index.php?page=logout"><i class="fas fa-sign-out-alt fa-fw"></i> Logout</a>
                </div>
            </li>
        </ul>

    </div>
</nav>

<main role="main">

    <div class="container">
        <?php

            frontController($_GET['page']);

        ?>
    </div>

</main>

<footer class="container">
    <hr>
    <p>miniCloud | aryx</p>
</footer>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/minicloud.js"></script>

</body>
</html>
