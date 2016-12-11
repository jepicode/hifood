<?php
    require_once("connect.php");
    $sql = mysql_query("SELECT * FROM images WHERE id_user='$_SESSION[hifood_id]'");
    $r = mysql_fetch_array($sql);
    $sql1 = mysql_query("SELECT * FROM user WHERE id_user='$_SESSION[hifood_id]'");
    $r1 = mysql_fetch_array($sql1);
?>
<div id="user-info-menu">
    <div id="round">
        <div id="user-photo">
            <img src="<?php echo $r['url']?>" id="user-image" style="display:none;">  
        </div>
    </div>
    <div id="user-name">
        <?php echo ucwords($_SESSION['hifood_user']); ?>
    </div>
</div>
<div id="user-menu">
    <div id="home-menu" onclick="window.location='profile.php'">Beranda</div>
    <div id="setting-menu" onclick="window.location='edit-profile.php'">Ubah Profil</div>
    <div id="chat-menu" onclick="window.location='list-chat.php'">Percakapan</div>
</div>
<div id="real-menu">
    <div id="recipe-menu" onclick="window.location='index.php'">Resep Masakan</div>
    <div id="food-menu" onclick="window.location='food.php'">Makanan</div>
    <div id="search-menu" onclick="window.location='search.php'">Cari</div>
</div>
<div id="end-menu">
    <?php if($r1['role'] == "admin") { ?>
    <div id="admin-menu" onclick="window.location='admin.php'">Admin</div>
    <?php } ?>
    <div id="about-menu" onclick="window.location='about.php'">Tentang</div>
    <div id="logout-menu" onclick="window.location='session_destroy.php'">Keluar</div>
</div>
<div onclick="window.location='info.php'">Info</div>

<script>
    $("#user-image").on("load",function(){
        var width = 125;
        var height = 125;
        var widthimg = $("#user-image")[0].naturalWidth;
        var heightimg = $("#user-image")[0].naturalHeight;
        $("#user-photo").css({"background":"#fff url(<?php echo $r['url']."?t=".rand() ?>) center center no-repeat"});
        if(heightimg < widthimg) {
            $("#user-photo").css("background-size","auto "+height+"px");
        }
        else
            $("#user-photo").css("background-size",width+"px auto");
    });
    $("#<?php echo $_GET['page']; ?>").addClass("active");  
</script>