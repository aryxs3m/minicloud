<?php
/**
 * Created by PhpStorm.
 * User: aryx
 * Date: 2019.05.13.
 * Time: 17:22
 */

$status = 0;

if (isset($_POST['submit'],$_POST['newpassword'],$_POST['newpassword2'])) {

    $password = filter_input(INPUT_POST, "newpassword", FILTER_SANITIZE_STRING);
    $password2 = filter_input(INPUT_POST, "newpassword2", FILTER_SANITIZE_STRING);

    if ($password == $password2 && strlen($password) >= 5) {

        $userid = $_SESSION["user_id"];
        $conn = connectDB();

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt=$conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $password_hash, $userid);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        $status = 2;

    } else {
        $status = 1;
    }



}

?>

<h1>Settings</h1>

<?php

    switch ($status) {
        case 1:
            echo "<div class='alert alert-danger' role='alert'>Passwords doesn't match or shorter than 5 characters!</div>";
            break;

        case 2:
            echo "<div class='alert alert-success' role='alert'>Password changed!</div>";
            break;
    }

?>

<form method="post">
    <div class="form-group">
        <label for="inputPassword1">New password</label>
        <input type="password" name="newpassword" class="form-control" id="inputPassword1" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="inputPassword2">New password again</label>
        <input type="password" name="newpassword2" class="form-control" id="inputPassword2" placeholder="Password">
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>