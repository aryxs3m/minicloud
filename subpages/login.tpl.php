<?php
/**
 * Created by PhpStorm.
 * User: aryx
 * Date: 2019.05.14.
 * Time: 12:17
 */

$error = 0;

if (isset($_POST['submit'], $_POST['username'], $_POST['password'])) {

    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);

    $conn = connectDB();

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->bind_result($id, $password_hash);
    $stmt->execute();
    $stmt->fetch();

    $stmt->close();
    $conn->close();


    if (password_verify($password, $password_hash)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $username;
        header("Location:index.php");
    } else {
        $error = 1;
    }

}



?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="aryx">

    <title>miniCloud</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>
<body class="text-center">
<form class="form-signin" method="post">
    <img class="mb-4" src="images/minicloud.svg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">miniCloud login</h1>

    <?php

        if ($error == 1) {
            echo "<div class='alert alert-danger' role='alert'>Bad password or username!</div>";
        }

    ?>

    <label for="inputUsername" class="sr-only">Username</label>
    <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
<!--    <div class="checkbox mb-3">-->
<!--        <label>-->
<!--            <input type="checkbox" value="remember-me"> Remember me-->
<!--        </label>-->
<!--    </div>-->
    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">miniCloud</p>
</form>
</body>
</html>
