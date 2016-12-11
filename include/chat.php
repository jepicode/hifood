<?php
require("connect.php");

if($_GET['id']  == $_SESSION['hifood_id'])
    echo "<script>window.location='list-chat.php'</script>";

$sql = mysql_query("SELECT * FROM user WHERE id_user='$_GET[id]'");
if(mysql_num_rows($sql) == 0){
    echo "<script>window.location='index.php'</script>";
}
else {
    $r = mysql_fetch_array($sql);
    
?>
<div id="chat-title">
    <?php echo $r['fullname']; ?>
</div>
<div id="divchat">

    <?php
        $sql1 = mysql_query("SELECT * FROM chat WHERE (id_user='$_SESSION[hifood_id]' AND to_id_user='$_GET[id]') OR (id_user='$_GET[id]' AND to_id_user='$_SESSION[hifood_id]') ORDER BY id_chat ASC") or die(mysql_error());
        $i = 1;
        while($r1 = mysql_fetch_array($sql1)){
            if($i == mysql_num_rows($sql1))
                echo "<div id='last' class='$r1[id_chat]'></div>";
            $i++;
    ?>
    <div id="chat-box" <?php if($r1['id_user'] == $_SESSION['hifood_id']) echo "class='chat-right'"; else echo "class='chat-left'"; ?> >
        <?php echo $r1['chat']; ?>
    </div>
    <?php
        }
        $sql1 = mysql_query("SELECT * FROM chat WHERE (id_user='$_SESSION[hifood_id]' AND to_id_user='$_GET[id]') OR (id_user='$_GET[id]' AND to_id_user='$_SESSION[hifood_id]') ORDER BY id_chat DESC LIMIT 1") or die(mysql_error());
        $r1 = mysql_fetch_array($sql1);
        if($r1['to_id_user'] == $_GET['id']) {
            if($r1['status'] == "read"){
                echo "<div id='status'>Dibaca</div>";
            }
            else
                echo "<div id='status'>Terkirim</div>";
        }
    ?>
    <div id="new-chat" style="display:none">
        
    </div>
</div>
<?php
}
?>
<script>
    var height = $(window).height();
</script>
