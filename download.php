<?php
/**
 * Created by PhpStorm.
 * User: aryx
 * Date: 2019.05.13.
 * Time: 18:02
 */

require_once "config.inc.php";
require_once "system.inc.php";

session_start();

checkLogin();

$user = $_SESSION['user_name'];

if (!isset($_GET['file'])) {
    http_response_code(400);
    exit;
}

$filePath = home_directory_root . "{$user}/" . filter_input(INPUT_GET, 'file', FILTER_SANITIZE_STRING);

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
    http_response_code(404);
    exit;
}


?>