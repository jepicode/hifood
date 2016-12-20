<?php
    require_once("connect.php");
    $sql = mysql_query("SELECT * FROM images WHERE id_user='$_SESSION[hifood_id]'");
    $r = mysql_fetch_array($sql);
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
    <div id="about-menu">Tentang</div>
    <div id="logout-menu">Keluar</div>
</div>

<script>
    var widthimg = $("#user-image")[0].naturalWidth;
    var heightimg = $("#user-image")[0].naturalHeight;
    var width = 125;
    var height = 125;
    var widthnew = width/widthimg;
    var heightnew = height/heightimg;
    $("#user-photo").css({"background":"#fff url(<?php echo $r['url']."?t=".rand() ?>) center center no-repeat"});
    if(heightimg * widthnew < height) {
        $("#user-photo").css("background-size","auto "+height+"px");
    }
    else
        $("#user-photo").css("background-size",width+"px auto");
    $("#<?php echo $_GET['page']; ?>").addClass("active");  
</script>