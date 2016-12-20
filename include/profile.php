<?php
require("connect.php");

if($_GET['id'] == "undefined")
    $_GET['id'] = $_SESSION['hifood_id'];
$sql = mysql_query("SELECT * FROM user WHERE id_user='$_GET[id]'") or die(mysql_error());
$sql1 = mysql_query("SELECT * FROM images WHERE type='post' AND id_post='$_GET[id]'");
if(mysql_num_rows($sql) == 0){
    echo "<script>window.location='index.php'</script>";
}
else {
    $r = mysql_fetch_array($sql);
    $r1 = mysql_fetch_array($sql1);
    $r2 = mysql_fetch_array(mysql_query("SELECT * FROM images WHERE id_user='$r[id_user]' AND type='user'"));
}
?>
<div id="profile">
    <div id="header-profile">
        <div id="round-photo">
            <div id="photo-author">
                <img src="<?php echo $r2['url']."?t=".rand();?>" id="image-user" style="display:none">
            </div>
        </div>
        <div id="user-info">
            <?php echo ucwords($r['fullname']); ?>
        </div>
        <div id="user-bio">
            <b>Bio :</b><?php echo $r['description']; ?>
        </div>
    
        <div id="send">
        <?php
            if($r['id_user'] != $_SESSION['hifood_id']) {
        ?>
            <div id="send-chat" onclick="window.location='chat.php?id=<?php echo $r['id_user']; ?>'">
                Kirim Pesan
            </div>        
        <?php
            }
        ?>
        </div>
    </div>
    <div id="info-post">
        
    </div>
</div>


<script>
    autosize($('textarea'));
    if($(window).width() > $(window).height())
        $("#photo-image").height($(window).height()/2);
    else
        $("#photo-image").height($(window).width()/2);
    $("#image-user").on("load",function(){
        $("#photo-author").css({"background":"#fff url(<?php echo $r2['url']; ?>) center center no-repeat"});
        $("#photo-author").css("background-size","100px auto");
    });
</script>