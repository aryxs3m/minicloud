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