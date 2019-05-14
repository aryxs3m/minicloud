<?php
/**
 * Created by PhpStorm.
 * User: aryx
 * Date: 2019.05.14.
 * Time: 14:34
 */

    require "config.inc.php";
    require "system.inc.php";

    if (!isset($_GET['code'])) {
        echo "Bad download code provided!";
        exit;
    }

    $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);

    $conn = connectDB();
    $stmt = $conn->prepare("SELECT username, filepath FROM shares LEFT JOIN users ON users.id = shares.user_id WHERE share_code = ?");
    $stmt->bind_param("s", $code);
    $stmt->bind_result($username, $filepath);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    if ($username == null || $filepath == null) {
        echo "Share not found!";
        exit;
    }

    if (substr($filepath, 0,1) !== "/") {
        $filepath = "/{$filepath}";
    }

    $filePath = home_directory_root . "{$username}{$filepath}";

    if (file_exists($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        flush(); // Flush system output buffer
        readfile($filePath);
        exit;
    } else {
        echo "File not found!";
        exit;
    }

?>


