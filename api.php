<?php
/**
 * Created by PhpStorm.
 * User: aryx
 * Date: 2019.05.13.
 * Time: 18:32
 */

    include_once "config.inc.php";
    include_once "system.inc.php";

    session_start();

    checkLogin();

    function newFolder() {
        if (!isset($_POST['path'], $_POST['folderName'])) {
            http_response_code(400);
            exit;
        }

        $user = $_SESSION['user_name'];

        if (mkdir(home_directory_root . "{$user}/{$_POST['path']}/{$_POST['folderName']}")) {
            echo "ok";
        } else {
            http_response_code(500);
            exit;
        }
    }

    function uploadFile() {
        if (!isset($_POST['path'])) {
            http_response_code(400);
            exit;
        }

        $user = $_SESSION['user_name'];

        if (trim($_POST['path']) == "") {
            $target_dir = home_directory_root . "{$user}/";
        } else {
            $target_dir = home_directory_root . "{$user}/{$_POST['path']}/";
        }



        foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {

            $target_file = $target_dir . basename($_FILES["file"]["name"][$key]);
            $uploadOk = 1;

            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";

            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"][$key], $target_file)) {
                    echo "The file ". basename( $_FILES["file"]["name"][$key]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

        }


    }


    function deleteFile() {
        if (!isset($_POST['path'], $_POST['file'])) {
            http_response_code(400);
            exit;
        }

        $user = $_SESSION["user_name"];

        if (unlink(home_directory_root . "{$user}/{$_POST['path']}/{$_POST['file']}")) {
            echo "ok";
        } else {
            http_response_code(500);
            exit;
        }
    }



    function shareFile() {
        if (!isset($_POST['path'], $_POST['file'])) {
            http_response_code(400);
            exit;
        }

        $userid = $_SESSION["user_id"];
        $filepath = "{$_POST['path']}/{$_POST['file']}";
        $code = bin2hex(openssl_random_pseudo_bytes(16));

        $conn = connectDB();

        $stmt = $conn->prepare("INSERT INTO shares (user_id, filepath, share_code) VALUES (?,?,?)");
        $stmt->bind_param("iss", $userid, $filepath, $code);
        $stmt->execute();

        if (!empty($stmt->error)) {
            http_response_code(500);
            exit;
        }

        $stmt->close();
        $conn->close();

        echo minicloud_url . "/share.php?code=$code";
    }



    if (!isset($_POST['request'])) {
        http_response_code(400);
        exit;
    } else {
        switch ($_POST['request']) {
            case "newFolder": newFolder(); break;
            case "uploadFile": uploadFile(); break;
            case "deleteFile": deleteFile(); break;

            case "logoutNow": session_destroy(); break;

            default: http_response_code(400); exit;
        }
    }


?>