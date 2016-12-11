<?php
require("connect.php");
if(!isset($_GET['id'])){
    echo "<script>window.location='index.php'</script>";
}
else {
    $sql = mysql_query("SELECT * FROM post WHERE id_post='$_GET[id]' AND id_user='$_SESSION[hifood_id]'");
    $sql1 = mysql_query("SELECT * FROM images WHERE id_post='$_GET[id]'");
    $sql2 = mysql_query("SELECT * FROM comment WHERE id_post='$_GET[id]'");
    $sql3 = mysql_query("SELECT * FROM love WHERE id_post='$_GET[id]'");
    if(mysql_num_rows($sql) == 0)
        echo "<script>window.location='index.php'</script>";
    else {
        $r = mysql_fetch_array($sql);
        $r1 = mysql_fetch_array($sql1);
            if($r['type'] == "recipe"){
                $urldelete = "../".$r1['url'];
                unlink($urldelete);
            }
            else {
                $url = explode(",",$r1['url']);
                $i = 0;
                while($i < sizeof($url)-1){
                    $urldelete = "../".$url[$i];
                    unlink($urldelete);
                    $i++;
                }
            }
        
        mysql_query("DELETE FROM images WHERE id_post='$_GET[id]'");
        if(mysql_num_rows($sql2) > 0)
            mysql_query("DELETE FROM comment WHERE id_post='$_GET[id]'");
        if(mysql_num_rows($sql3) > 0)
            mysql_query("DELETE FROM love WHERE id_post='$_GET[id]'");
        if(mysql_query("DELETE FROM post WHERE id_post='$_GET[id]'")) {
            echo "success";
        }
    }
}
?>