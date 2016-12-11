<?php
    error_reporting(E_ALL ^ E_DEPRECATED);
    session_start();
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "hifood";
    mysql_connect($host,$user,$pass);
    mysql_select_db($db);
?>