<?php
    require("connect.php");
    require("date.php");
    $sql = mysql_query("SELECT * FROM post WHERE type='food' AND id_post='$_GET[id]'");
    if(mysql_num_rows($sql) == 0)
        echo "<script>window.location='food.php'</script>";
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
            <div id="left-right">
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
    #content-image {
        width:100%; clear: both; display: block;
    }
</style>

<?php
    if($r['id_user'] != $_SESSION['hifood_id']){
        echo "<script>$('#delete').hide()</script>";
    }
?>

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
        $(".<?php echo $r['id_post']?>-1").height($(window).height()/2);
        $(".<?php echo $r['id_post']?>-2").height($(window).height()/2);
    }
    else {
        $(".<?php echo $r['id_post']?>-0").height($(window).width()/2);
        $(".<?php echo $r['id_post']?>-1").height($(window).width()/2);
        $(".<?php echo $r['id_post']?>-2").height($(window).width()/2);
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
    
</script>
<?php
    }
?>
