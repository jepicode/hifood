<?php
require("connect.php");
if(isset($_GET['set']) && $_GET['set'] == "read"){
    $sqlz = mysql_query("UPDATE chat SET status='read' WHERE id_user='$_GET[id]' AND to_id_user='$_SESSION[hifood_id]'");
}
else {
    $sql = mysql_query("SELECT * FROM chat WHERE id_user='$_SESSION[hifood_id]' AND to_id_user='$_GET[id]' ORDER BY id_chat DESC");
    $r = mysql_fetch_array($sql);
    echo $r['status'];
}
?>