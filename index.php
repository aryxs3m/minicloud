<?php
/**
 * Created by PhpStorm.
 * User: aryx
 * Date: 2019.05.13.
 * Time: 16:42
 */


    require "config.inc.php";
    require "system.inc.php";

    session_start();

    checkLogin();

    require_once "template.php";

?>
