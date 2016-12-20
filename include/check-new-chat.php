<?php
require_once("connect.php");
if(isset($_GET['for'])){
    if($_GET['for'] == "listchat"){
        if(isset($_SESSION['time_check']) && $_SESSION['time_check'] != null){
            $time = $_SESSION['time_check'];
        }
        else {
            date_default_timezone_set("Asia/Bangkok");
            $_SESSION['time_check'] = date("Y-m-d H:i:s");
            $time = $_SESSION['time_check'];
        }
        $sql = mysql_query("SELECT * FROM chat WHERE (id_user='$_SESSION[hifood_id]' OR to_id_user='$_SESSION[hifood_id]') AND date > '$time'");
        echo mysql_num_rows($sql);
        date_default_timezone_set("Asia/Bangkok");
        $_SESSION['time_check'] = date("Y-m-d H:i:s");
    }
    else if($_GET['for'] == "check"){
        if(isset($_SESSION['time_check']) && $_SESSION['time_check'] != null){
            $time = $_SESSION['time_check'];
        }
        else {
            date_default_timezone_set("Asia/Bangkok");
            $_SESSION['time_check'] = date("Y-m-d H:i:s");
            $time = $_SESSION['time_check'];
        }
        $sql = mysql_query("SELECT * FROM chat WHERE (id_user='$_SESSION[hifood_id]' OR to_id_user='$_SESSION[hifood_id]') AND date > '$time'");
        echo mysql_num_rows($sql);
    }
}
else {
    $sql = mysql_query("SELECT * FROM chat WHERE id_user='$_GET[id]' AND to_id_user='$_SESSION[hifood_id]' AND id_chat > '$_GET[last]' ORDER BY id_chat DESC LIMIT 1");
    $sql1 = mysql_query("SELECT * FROM user WHERE id_user='$_GET[id]'");
    $r1 = mysql_fetch_array($sql1);
    if(mysql_num_rows($sql) > 0) {
        $r = mysql_fetch_array($sql);
        echo ucwords($r1['username'])." : ".$r['chat'];
    }
}
?>