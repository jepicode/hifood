<?php
    require_once("connect.php");
    if(isset($_GET['page']) && $_GET['page'] == "login"){
        if(isset($_GET['check']) && $_GET['check'] == "true") {
            $user = $_GET['user'];
            $pass = md5($_GET['pass']);
            $sql = mysql_query("SELECT * FROM user WHERE username='$_GET[user]' AND password='$pass'") or die(mysql_error());
            if(mysql_num_rows($sql) != 0){
                echo "yes";
                $r = mysql_fetch_array($sql);
                $_SESSION['hifood_login'] = true;
                $_SESSION['hifood_id'] = $r['id_user'];
                $_SESSION['hifood_user'] = $r['username'];
            }
            else
                echo "no";
        }
        else {
            if(isset($_SESSION['hifood_login']) && $_SESSION['hifood_login'] == true)
                echo "yes";
            else
                echo "no";
        }
    }
    else {
        if(!isset($_SESSION['hifood_login']) || $_SESSION['hifood_login'] != true){
            echo "yes";
        }
        else
            echo "no";
    }
?>