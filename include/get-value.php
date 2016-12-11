<?php
require("connect.php");
require("str_replace.php");
$sql = mysql_query("SELECT * FROM user WHERE id_user='$_SESSION[hifood_id]'");
$r = mysql_fetch_array($sql);
$desc = back($r['description']);
$user = back($r['username']);
$full = back($r['fullname']);
echo $user."|".$full."|".$desc;
?>