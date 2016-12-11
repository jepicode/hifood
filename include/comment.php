<?php
require_once("connect.php");
require_once("str_replace.php");
if(isset($_GET['type'])){
    if($_GET['type'] == "com"){
        $sql = mysql_query("SELECT * FROM comment ORDER BY id_comment DESC LIMIT 1");
        $r = mysql_fetch_array($sql);
        $id = explode("_",$r['id_comment']);
        $id = (int)$id[1];
        if($id >= 0 && $id < 9) $id = "COM_0000".($id+1);
        else if($id >= 9 && $id < 99) $id = "COM_000".($id+1);
        else if($id >= 99 && $id < 999) $id = "COM_00".($id+1);
        else if($id >= 999 && $id < 9999) $id = "COM_0".($id+1);
        else $id = "COM_".($id+1);
        date_default_timezone_set("Asia/Bangkok");
        $date = date("Y:m:d H:i:s");
        $comment = replace($_GET['comment']);
        $sql = mysql_query("INSERT INTO comment VALUES('$id', '$_SESSION[hifood_id]', '$_GET[id]', '$comment','$date')") or die(mysql_error());
    }
}
else {
    $sql = mysql_query("SELECT * FROM comment WHERE id_post='$_GET[id]' ORDER BY id_comment ASC");
    if(mysql_num_rows($sql) == 0){
        echo "Belum ada Komentar";
    }
    else {
        while($r = mysql_fetch_array($sql)){
            $r1 = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE id_user='$r[id_user]'"));
?>  
    <div id="com">
        <div id="header-com">
            <?php echo ucwords($r1['username']); ?>
        </div>
        <div id="content-com">
            <?php echo $r['comment']?>
        </div>
    </div>
<?php
        }
    }
}
?>