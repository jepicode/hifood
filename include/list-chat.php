<?php
	require_once("connect.php");
    date_default_timezone_set("Asia/Bangkok");
    $_SESSION['time_check'] = date("Y-m-d H:i:s");
	$sql = mysql_query("SELECT * FROM user WHERE username='$_SESSION[hifood_user]'");
	$r = mysql_fetch_array($sql);
	$sql1 = mysql_query("SELECT * FROM (SELECT * FROM chat WHERE id_user='$r[id_user]' OR to_id_user='$r[id_user]' ORDER BY id_chat DESC) AS t GROUP BY id_user, to_id_user ORDER BY id_chat DESC");
	if(mysql_num_rows($sql1) != 0){
		while($r1 = mysql_fetch_array($sql1)){
			$sql2 = mysql_query("SELECT * FROM chat WHERE id_user='$r1[id_user]' AND to_id_user='$r1[to_id_user]' ORDER BY id_chat DESC LIMIT 1");
			$sql3 = mysql_query("SELECT * FROM chat WHERE id_user='$r1[to_id_user]' AND to_id_user='$r1[id_user]' ORDER BY id_chat DESC LIMIT 1");
			if(mysql_num_rows($sql2) != 0) {
				$r2 = mysql_fetch_array($sql2);
				$id1 = explode("_",$r2['id_chat']);
				$id1 = (int)$id1[1];
			}
			else	$id1 = 0;
			if(mysql_num_rows($sql3) != 0) {
				$r3 = mysql_fetch_array($sql3);
				$id2 = explode("_",$r3['id_chat']);
				$id2 = (int)$id2[1];
			}
			else	$id2 = 0;
			if($id1 > $id2) {
				if($r2['id_user'] == $r['id_user'])
					$id_user = $r2['to_id_user'];
				else
					$id_user = $r2['id_user'];
				$id_chat = $r2['id_chat'];
				$to_id_user = $r2['to_id_user'];
				$chat = $r2['chat'];
				$date = $r2['date'];
				$status = $r2['status'];
				
				$rr = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE id_user = '$id_user'"));
?>
	<div id="list-chats" onclick="window.location='chat.php?id=<?php echo $id_user ?>'">
    	<div id="title-chat" <?php if($r2['id_user'] != $r['id_user'] && $status == "deliv") echo "style='font-weight:bold'" ?>>
        	<?php echo ucwords($rr['username']); ?>
        </div>
        <div id="content-content" <?php if($r2['id_user'] != $r['id_user'] && $status == "deliv") echo "style='font-weight:bold'" ?>>
        	<?php echo $chat; ?>
        </div>
    </div>
<?php	
			}
?>
<?php
		}
	}
?>
	