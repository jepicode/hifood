<?php
    require_once("connect.php");
    if(strpos($_GET['id'],"-") !== false){
        $exp = explode("-",$_GET['id']);
        $id = $exp[0];
        $ext = true;
    }
    else {
        $id = $_GET['id'];
    }
    $sql = mysql_query("SELECT * FROM images WHERE id_post='$id'");
    $r = mysql_fetch_array($sql);
    if(isset($ext)){
        $images = explode(",",$r['url']);
        $images = $images[$exp[1]];
    }
    else
        $images = $r['url'];
?>
    <img src="<?php echo $images."?t=".rand(); ?>" id="big-img">

<script>
    $("#big-img").on("load",function(){
        var widthimg = $("#big-img")[0].naturalWidth;
        var heightimg = $("#big-img")[0].naturalHeight;
        var width = $(window).width();
        var height = $(window).height();
        var widthnew = width/widthimg;
        var heightnew = height/heightimg;
        if(widthimg < width && heightimg < height){
            $("#big-img").height(heightimg).width(widthimg).animate({"margin-top":"-"+(heightimg/2)+"px", "margin-left":"-"+(widthimg/2)+"px"});
        }
        else if(widthimg > heightimg){
            if(heightimg * widthnew > height) 
                $("#big-img").height(height).width(widthimg*heightnew).animate({"margin-top":"-"+(height/2)+"px","margin-left":"-"+(widthimg*heightnew/2)+"px"});
            else
                $("#big-img").height(heightimg*widthnew).width(width).animate({"margin-top":"-"+(heightimg*widthnew/2)+"px","margin-left":"-"+(width/2)+"px"});
        }
        else {
            if(heightimg * widthnew > height) 
                $("#big-img").height(height).width(widthimg*heightnew).animate({"margin-top":"-"+(height/2)+"px","margin-left":"-"+(widthimg*heightnew/2)+"px"});
            else
                $("#big-img").height(heightimg*widthnew).width(width).animate({"margin-top":"-"+(heightimg*widthnew/2)+"px","margin-left":"-"+(width/2)+"px"});
        }        
    });
</script>