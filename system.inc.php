<?php
/**
 * Created by PhpStorm.
 * User: aryx
 * Date: 2019.05.13.
 * Time: 16:43
 */

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

    $user = "aryx"; //TODO: you know...


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