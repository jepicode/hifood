<?php
require("connect.php");
if(isset($_GET['check']) && $_GET['check'] == true){
    if(!isset($_SESSION['hifood_browser']) || $_SESSION['hifood_browser'] == false)
        echo "false";
    else
        echo "true";
}
if(isset($_GET['update']) && $_GET['update'] == true){
    $_SESSION['hifood_browser'] = true;
}
?>