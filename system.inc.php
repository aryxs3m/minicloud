<?php
/**
 * Created by PhpStorm.
 * User: aryx
 * Date: 2019.05.13.
 * Time: 16:43
 */

function checkLogin() {
    if (!isset($_SESSION['user_id'], $_SESSION['user_name'])) {
        include_once "subpages/login.tpl.php";
        exit;
    }
}

function connectDB() {
    $conn = new mysqli(mysql_server, mysql_user, mysql_password, mysql_database);
    $conn->query("SET NAMES UTF8");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function createAdmin($username, $password) {

    $conn = connectDB();

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?,?)");

    $stmt->bind_param("ss", $username, $password);

    $password = password_hash($password, PASSWORD_BCRYPT);
    $stmt->execute();

    $stmt->close();
    $conn->close();

}


function frontController(&$page) {
    if (isset($page)) {

        if (file_exists("subpages/{$page}.tpl.php")) {
            include_once "subpages/{$page}.tpl.php";
        } else {
            include_once "subpages/index.tpl.php";
        }
    } else {
        include_once "subpages/index.tpl.php";
    }
}


function generateFaIcon($filePath) {

    $user = $_SESSION['user_name'];


    $mime = mime_content_type(home_directory_root . "{$user}//" . $filePath);

    // 1] we check for the first part (audio, video, image, text, etc.)
    switch (explode("/", $mime)[0]) {
        case "audio": return "fa-file-audio"; break;
        case "video": return "fa-file-video"; break;
        case "image": return "fa-file-image"; break;
        case "text": return "fa-file-alt"; break;
        case "application":
            // 2] we check for the second part on applications
            switch (explode("/", $mime)[1]) {
                //case "octet-stream": return "file-"; // TODO: need good binary file icon
                case "x-bzip": return "fa-file-archive"; break;
                case "x-bzip2": return "fa-file-archive"; break;
                case "x-tar": return "fa-file-archive"; break;
                case "zip": return "fa-file-archive"; break;
                case "x-7z-compressed": return "fa-file-archive"; break;
                case "x-rar-compressed": return "fa-file-archive"; break;
                case "x-freearc": return "fa-file-archive"; break;

                case "rtf": return "fa-file-word"; break;
                case "x-abiword": return "fa-file-word"; break;
                case "msword": return "fa-file-word"; break;
                case "vnd.openxmlformats-officedocument.wordprocessingml.document": return "fa-file-word"; break;
                case "vnd.oasis.opendocument.text": return "fa-file-word"; break;

                case "vnd.oasis.opendocument.presentation": return "fa-file-powerpoint"; break;
                case "vnd.ms-powerpoint": return "fa-file-powerpoint"; break;
                case "vnd.openxmlformats-officedocument.presentationml.presentation": return "fa-file-powerpoint"; break;

                case "vnd.oasis.opendocument.spreadsheet": return "fa-file-excel"; break;
                case "vnd.ms-excel": return "fa-file-excel"; break;
                case "vnd.openxmlformats-officedocument.spreadsheetml.sheet": return "fa-file-excel"; break;

                default: return "fa-file";
            }
            break;

        default: return "fa-file";
    }

}