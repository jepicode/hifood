<?php
    require("connect.php");
    require("date.php");
    $type = $_GET['type'];
    
    if(isset($_GET['limit'])){
        $limit = $_GET['limit']+3;
    }
    else {
        $limit = 3;
    }
    if($type == "new"){
        if(isset($_GET['btn']) && $_GET['btn'] == "loadmore"){
            $sql = mysql_query("SELECT * FROM post WHERE type='food' AND id_post < '$_GET[ends]' ORDER BY id_post DESC LIMIT 3");
        }
        else if(isset($_GET['id'])){
            if($_GET['id'] == "undefined")
                $id = $_SESSION['hifood_id'];
            else
                $id = $_GET['id'];
            $sql = mysql_query("SELECt * FROM post WHERE type='food' AND id_user='$id' ORDER BY id_post DESC");
            if(mysql_num_rows($sql) == 0)
                echo "<div id='nopost'>Belum ada Makanan yang dibagikan</div>";
        }
        else if(isset($_GET['search'])){
            if($_GET['search'] == "undefined")
                $id = $_SESSION['hifood_id'];
            else
                $id = $_GET['search'];
            $sql = mysql_query("SELECT * FROM post WHERE type='food' AND (post LIKE '%$id%' OR cooking_name LIKE '%$id%') ORDER BY id_post DESC");
            if(mysql_num_rows($sql) == 0)
                echo "<div id='nopost'>Tidak ada Resep Makanan yang cocok</div>";
        }
        else {
            $sql = mysql_query("SELECT * FROM post WHERE type='food' ORDER BY id_post DESC LIMIT 3");
        }
    }
    else {
        if(isset($_GET['btn']) && $_GET['btn'] == "loadmore"){
            $sql = mysql_query("SELECT post.*, COUNT(love.id_love) as number from post LEFT JOIN love ON love.id_post = post.id_post GROUP BY post.id_post HAVING number >= 1 AND type='food' AND id_post < '$_GET[ends]' ORDER BY id_post DESC LIMIT 3");
        }
        else {
            $sql = mysql_query("SELECT post.*, COUNT(love.id_love) as number from post LEFT JOIN love ON love.id_post = post.id_post GROUP BY post.id_post HAVING number >= 1 AND type='food' ORDER BY id_post DESC LIMIT 3");
        }
    }
    $i = 1;
    $first = "";
    $ends = "";
    while($r = mysql_fetch_array($sql)){
        $r1 = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE id_user='$r[id_user]'"));
        $r2 = mysql_num_rows(mysql_query("SELECT * FROM love WHERE id_post='$r[id_post]'"));
        $r3 = mysql_fetch_array(mysql_query("SELECT * FROM images WHERE id_user='$r[id_user]'"));
        $r4 = mysql_fetch_array(mysql_query("SELECT * FROM images WHERE id_post='$r[id_post]'"));
        if(isset($_SESSION['hifood_id'])) 
            $r5 = mysql_num_rows(mysql_query("SELECT * FROM love WHERE id_post='$r[id_post]' AND id_user='$_SESSION[hifood_id]'"));
        else 
            $r5 = 0;
        
        if($i == 1) {
            if(isset($_GET['btn']) && $_GET['btn'] == "loadmore") {
                $first = $_GET['first'];
            }
            else {
                $first = $r['id_post'];
            }
        }
        if($i == mysql_num_rows($sql)) {
            $ends = $r['id_post'];
        }
        $i++;
        
        $start = new DateTime($r['date']);
		$end = date('Y-m-d H:i:s');
        $images = explode(",",$r4['url']);
        $size = count($images)-1;
?>
<div id="post">
    <div id="header-post">
        <div id="left">
            <div id="image" class="<?php echo $r['id_user']?>">
                <img src="<?php echo $r3['url']."?t=".rand(); ?>" class="img-<?php echo $r['id_user']; ?>" style="display:none">
            </div>
            <div id="left-right" onclick="window.location='detail-food.php?id=<?php echo $r['id_post']; ?>'">
                <div id="title">
                    <?php echo $r['cooking_name']; ?>
                </div>
                <div id="author">
                    oleh <?php echo ucwords($r1['username']); ?>
                </div>
            </div>
        </div>
        <div id="right">
            <div id="time">
                <?php datedif($start,$end);?>
            </div>
            <div id="love" class="love-<?php echo $r['id_post']; if($r5 > 0) echo " active" ?>">
                <?php echo $r2 ?>   
            </div>
        </div>
    </div>
    <div id="content-post">
        <div id="desc">
            <?php echo $r['post']; ?>
        </div>
        <?php
        $i = 0;
        echo "<div id='ada$size'>";
        while($i < $size){
        ?>
        <div id="content-image" class="<?php echo $r['id_post']."-".$i; ?> ke<?php echo $i?>">
            <img src="<?php echo $images[$i]."?t=".rand(); ?>" class="img-<?php echo $r['id_post']."-".$i;?>" style="display:none">
        </div>
        <?php
            $i++;
        }
        echo "</div>";
        ?>
    </div>
</div>

<style>
    #ada3 {
        overflow: hidden;
    }
    #content-image {
        margin:0 !important;
    }
    #ada3 .ke0{
        width:75%; box-sizing: border-box; float:left;
    }
    #ada3 .ke1 {
        width: 25%; box-sizing: border-box; float:left;
    }
    #ada3 .ke2 {
        width:25%; box-sizing: border-box; float:left;
    }
    #ada2 {
        overflow: hidden;
    }
    #ada2 .ke0{
        width:50%; height:150px; box-sizing: border-box; float:left;
    }
    #ada2 .ke1 {
        width: 50%; height:150px; box-sizing: border-box; float:left;
    }
    #ada1 {
        overflow: hidden;
    }
    #ada1 .ke0{
        width:100%; border:1px solid #000; box-sizing: border-box; float:left;
    }
</style>

<script>
    <?php
        if($size == 1){
    ?>
    if($(window).width() > $(window).height()){
        $(".<?php echo $r['id_post']?>-0").height($(window).height()/2);
    }
    else {
        $(".<?php echo $r['id_post']?>-0").height($(window).width()/2);
    }
    $(".img-<?php echo $r['id_post'];?>-0").on("load",function(){
        $(".<?php echo $r['id_post']?>-0").css({"background":"url(<?php echo $images[0]."?t=".rand();?>) center center no-repeat"});
        var width = $(".<?php echo $r['id_post'];?>-0").width();
        var height = $(".<?php echo $r['id_post'];?>-0").height();
        var widthimg = $(".img-<?php echo $r['id_post'];?>-0")[0].naturalWidth;
        var heightimg = $(".img-<?php echo $r['id_post'];?>-0")[0].naturalHeight;
        if(heightimg*width/widthimg < height)
        $(".<?php echo $r['id_post']?>-0").css("background-size","auto "+height+"px");
        else
        $(".<?php echo $r['id_post']?>-0").css("background-size",width+"px auto");   
    });
    <?php
        }
        else if($size == 2){
    ?>
    if($(window).width() > $(window).height()){
        $(".<?php echo $r['id_post']?>-0").height($(window).height()/2);
        $(".<?php echo $r['id_post']?>-1").height($(window).height()/2);
    }
    else {
        $(".<?php echo $r['id_post']?>-0").height($(window).width()/2);
        $(".<?php echo $r['id_post']?>-1").height($(window).width()/2);
    }
    $(".img-<?php echo $r['id_post'];?>-0").on("load",function(){
        $(".<?php echo $r['id_post']?>-0").css({"background":"url(<?php echo $images[0]."?t=".rand();?>) center center no-repeat"});
        var width = $(".<?php echo $r['id_post'];?>-0").width();
        var height = $(".<?php echo $r['id_post'];?>-0").height();
        var widthimg = $(".img-<?php echo $r['id_post'];?>-0")[0].naturalWidth;
        var heightimg = $(".img-<?php echo $r['id_post'];?>-0")[0].naturalHeight;
        if(heightimg*width/widthimg < height)
        $(".<?php echo $r['id_post']?>-0").css("background-size","auto "+height+"px");
        else
        $(".<?php echo $r['id_post']?>-0").css("background-size",width+"px auto");   
    });
    $(".img-<?php echo $r['id_post'];?>-1").on("load",function(){
        $(".<?php echo $r['id_post']?>-1").css({"background":"url(<?php echo $images[1]."?t=".rand();?>) center center no-repeat"});
        var width = $(".<?php echo $r['id_post'];?>-1").width();
        var height = $(".<?php echo $r['id_post'];?>-1").height();
        var widthimg = $(".img-<?php echo $r['id_post'];?>-1")[0].naturalWidth;
        var heightimg = $(".img-<?php echo $r['id_post'];?>-1")[0].naturalHeight;
        if(heightimg*width/widthimg < height)
        $(".<?php echo $r['id_post']?>-1").css("background-size","auto "+height+"px");
        else
        $(".<?php echo $r['id_post']?>-1").css("background-size",width+"px auto");   
    });
    <?php
        }
        else if($size == 3){
    ?>
    if($(window).width() > $(window).height()){
        $(".<?php echo $r['id_post']?>-0").height($(window).height()/2);
        $(".<?php echo $r['id_post']?>-1").height($(window).height()/4);
        $(".<?php echo $r['id_post']?>-2").height($(window).height()/4);
    }
    else {
        $(".<?php echo $r['id_post']?>-0").height($(window).width()/2);
        $(".<?php echo $r['id_post']?>-1").height($(window).width()/4);
        $(".<?php echo $r['id_post']?>-2").height($(window).width()/4);
    }
    $(".img-<?php echo $r['id_post'];?>-0").on("load",function(){
        $(".<?php echo $r['id_post']?>-0").css({"background":"url(<?php echo $images[0]."?t=".rand();?>) center center no-repeat"});
        var width = $(".<?php echo $r['id_post'];?>-0").width();
        var height = $(".<?php echo $r['id_post'];?>-0").height();
        var widthimg = $(".img-<?php echo $r['id_post'];?>-0")[0].naturalWidth;
        var heightimg = $(".img-<?php echo $r['id_post'];?>-0")[0].naturalHeight;
        if(heightimg*width/widthimg < height)
        $(".<?php echo $r['id_post']?>-0").css("background-size","auto "+height+"px");
        else
        $(".<?php echo $r['id_post']?>-0").css("background-size",width+"px auto");   
    });
    $(".img-<?php echo $r['id_post'];?>-1").on("load",function(){
        $(".<?php echo $r['id_post']?>-1").css({"background":"url(<?php echo $images[1]."?t=".rand();?>) center center no-repeat"});
        var width = $(".<?php echo $r['id_post'];?>-1").width();
        var height = $(".<?php echo $r['id_post'];?>-1").height();
        var widthimg = $(".img-<?php echo $r['id_post'];?>-1")[0].naturalWidth;
        var heightimg = $(".img-<?php echo $r['id_post'];?>-1")[0].naturalHeight;
        if(heightimg*width/widthimg < height)
        $(".<?php echo $r['id_post']?>-1").css("background-size","auto "+height+"px");
        else
        $(".<?php echo $r['id_post']?>-1").css("background-size",width+"px auto");   
    });
    $(".img-<?php echo $r['id_post'];?>-2").on("load",function(){
        $(".<?php echo $r['id_post']?>-2").css({"background":"url(<?php echo $images[2]."?t=".rand();?>) center center no-repeat"});
        var width = $(".<?php echo $r['id_post'];?>-2").width();
        var height = $(".<?php echo $r['id_post'];?>-2").height();
        var widthimg = $(".img-<?php echo $r['id_post'];?>-2")[0].naturalWidth;
        var heightimg = $(".img-<?php echo $r['id_post'];?>-2")[0].naturalHeight;
        if(heightimg*width/widthimg < height)
        $(".<?php echo $r['id_post']?>-2").css("background-size","auto "+height+"px");
        else
        $(".<?php echo $r['id_post']?>-2").css("background-size",width+"px auto");   
    });
    <?php
        }
    ?>

    $(".img-<?php echo $r['id_user'];?>").on("load",function(){
        $(".<?php echo $r['id_user']?>").css({"background":"url(<?php echo $r3['url']."?t=".rand();?>) center center no-repeat"});
        $(".<?php echo $r['id_user']?>").css("background-size","50px auto");
    });
    
    $(".img-<?php echo $r['id_post'];?>").on("load",function(){
        var width = $(".<?php echo $r['id_post'];?>").width();
        $(".<?php echo $r['id_post']?>").css({"background":"url(<?php echo $r4['url']."?t=".rand();?>) center center no-repeat"});
        $(".<?php echo $r['id_post']?>").css("background-size",width+"px auto");
        
    });
</script>
<?php
    }
?>
<?php
if(!isset($_GET['id']) && !isset($_GET['search'])){
    if($type == "new"){
        $sql = mysql_query("SELECT * FROM post WHERE type='food' AND id_post < '$ends' ORDER BY id_post DESC");
    }
    else {
        $sql = mysql_query("SELECT post.*, COUNT(love.id_love) as number from post LEFT JOIN love ON love.id_post = post.id_post GROUP BY post.id_post HAVING number >= 2 AND type='food' AND id_post <'$ends' ORDER BY id_post DESC");
    }
    if(mysql_num_rows($sql) != 0){
?>
<div id="load-more" class="<?php echo "first-".$first." end-".$ends." limit-".$limit; ?>">Muat lebih lawas</div>
<?php
    }
}
?>