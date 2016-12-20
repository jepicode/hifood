<?php
require_once("connect.php");
$sql = mysql_query("SELECT * FROM post WHERE type='$_GET[type]' AND id_post > '$_GET[first]'");
echo mysql_num_rows($sql);
?>