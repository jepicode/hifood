<?php
    session_start();
    unset($_SESSION['hifood_splash']);
    unset($_SESSION['hifood_login']);
    unset($_SESSION['hifood_user']);
    unset($_SESSION['hifood_id']);
    unset($_SESSION['time_check']);
    header("location:index.php")
?>