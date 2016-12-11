<?php
require("connect.php");
$sql = mysql_query("SELECT * FROM user WHERE username='$_GET[name]'");
if(mysql_num_rows($sql)){
    echo "ada";
}
?>