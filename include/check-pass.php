<?php
require("connect.php");
$sql = mysql_query("SELECT * FROM user WHERE id_user='$_SESSION[hifood_id]' AND password='".md5($_GET['pass'])."'");
if(mysql_num_rows($sql) == 0)
    echo "no";
else
    echo "yes";
?>