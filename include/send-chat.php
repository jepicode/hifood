<?php
require_once("connect.php");
require_once("str_replace.php");
$sql = mysql_query("SELECT * FROM chat ORDER BY id_chat DESC LIMIT 1");
$r = mysql_fetch_array($sql);
$id = explode("_",$r['id_chat']);
$id = (int)$id[1];
if($id >= 0 && $id < 9) $id = "CHAT_0000".($id+1);
else if($id >= 9 && $id < 99) $id = "CHAT_000".($id+1);
else if($id >= 99 && $id < 999) $id = "CHAT_00".($id+1);
else if($id >= 999 && $id < 9999) $id = "CHAT_0".($id+1);
else $id = "CHAT_".($id+1);
date_default_timezone_set("Asia/Bangkok");
$date = date("Y:m:d H:i:s");
$chat = replace($_GET['chat']);
$sql = mysql_query("INSERT INTO chat VALUES('$id', '$_SESSION[hifood_id]', '$_GET[id]', '$chat', '$date', 'deliv')");
?>