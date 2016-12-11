<?php
    require_once("connect.php");
    if(!isset($_SESSION['hifood_splash'])) {
        if(isset($_GET['success']) && $_GET['success'] == "true"){
            $_SESSION['hifood_splash'] = true;
            echo "yes-success";
        }
        else
            echo "yes";
    }
    else
        echo "no";
?>