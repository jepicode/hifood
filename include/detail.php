<?php
require("connect.php");
$sql = mysql_query("SELECT * FROM post WHERE id_post='$_GET[id]' AND type='recipe'");
$sql1 = mysql_query("SELECT * FROM images WHERE type='post' AND id_post='$_GET[id]'");
if(mysql_num_rows($sql) == 0){
    echo "<script>window.location='index.php'</script>";
}
else {
    $r = mysql_fetch_array($sql);
    $r1 = mysql_fetch_array($sql1);
    $r2 = mysql_fetch_array(mysql_query("SELECT * FROM images WHERE id_user='$r[id_user]' AND type='user'"));
    $r3 = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE id_user='$r[id_user]'"));
    $time = explode(":",$r['cooking_time']);
    if((int)$time[0] > 0) {
        if((int)$time[1] > 30) 
           $time = "< ".((int)$time[0]+1)." Jam";
        else if((int)$time[1] > 0 && (int)$time[1] <= 30)
            $time ="> ".((int)$time[0])." Jam";
        else {
            $time = (int)$time[0]." Jam";
        }
    }
    else {
        $time = "&plusmn; ".(int)$time[1]." Menit";
    }
    $bahan = explode(",",$r['ingredients']);
    $i = 0;
    $bahan2 = "<ul>";
    while($i < count($bahan)-1){
        $bahan2 = $bahan2."<li>".$bahan[$i]."</li>";
        $i++;
    }
    $bahan2 = $bahan2."</ul>";
    $langkah = explode(",",$r['recipes']);
    $i = 0;
    $langkah2 = "<ol>";
    while($i < count($langkah)-1){
        $langkah2 = $langkah2."<li>".$langkah[$i]."</li>";
        $i++;
    }
    $langkah2 = $langkah2."</ol>";
}
?>
<div id="post">
    <div id="header-post">
        <div id="round-photo">
            <div id="photo-author">
                <img src="<?php echo $r2['url']?>" id="image-user" style="display:none">
            </div>
        </div>
        <div id="user-info">
            <?php echo ucwords($r3['username']); ?>
        </div>
        <div id="title-post">
            <?php echo ucwords($r['cooking_name']); ?>
        </div>
        <div id="photo-image" class="<?php echo $r['id_post']; ?>">
            <img src="<?php echo $r1['url']?>" id="image-photo" style="display:none">
        </div>
    </div>
    <div id="info-post">
        <div id="serving">
            <b><?php echo $r['serving']?> Porsi</b>
            per Masakan
        </div>
        <div id="time">
            <b><?php echo $time; ?></b>
            Waktu Memasak
        </div>
        <div id="level">
            <b><?php echo ucwords($r['cooking_level'])?></b>
            Tingkat Kesulitan
        </div>
    </div>
    <div id="tabs">
        <div id="desc" class="active">Deskripsi Masakan</div>
        <div id="bahan">Bahan-Bahan</div>
        <div id="langkah">Langkah-Langkah</div>
    </div>
    <div id="content-data">
        <?php echo $r['post']; ?>
    </div>
    
</div>

<?php
    if($r['id_user'] != $_SESSION['hifood_id']){
        echo "<script>$('#delete').hide()</script>";
    }
?>

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
    $("#image-photo").on("load",function(){
        $("#photo-image").css({"background":"#fff url(<?php echo $r1['url']; ?>) center center no-repeat"});
        $("#photo-image").css("background-size",$("#photo-image").width()+"px auto");
    });
    $("#desc").click(function(){
        $("#tabs div").removeClass("active");
        $("#desc").addClass("active");
        $("#content-data").html("<?php echo $r['post'] ?>");
    });
    $("#bahan").click(function(){
        $("#tabs div").removeClass("active");
        $("#bahan").addClass("active");
        $("#content-data").html("<?php echo $bahan2 ?>");
    });
    $("#langkah").click(function(){
        $("#tabs div").removeClass("active");
        $("#langkah").addClass("active");
        $("#content-data").html("<?php echo $langkah2 ?>");
    });
</script>