<?php
    require_once("connect.php");
    $id = $_GET['id'];
    $id = explode("-",$id);
    $ids = $id[1];
    $ids = explode(" ",$ids);
    $ids = $ids[0];
    $sql = mysql_query("SELECT * FROM love WHERE id_user='$_SESSION[hifood_id]' AND id_post='$ids'");
    if(mysql_num_rows($sql) == 0){
        $r = mysql_fetch_array(mysql_query("SELECT id_love FROM love ORDER BY id_love DESC LIMIT 1"));
        $id = explode("_",$r['id_love']);
        $id = (int)$id[1];
        if($id >= 0 && $id < 9) $id = "LOVE_0000".($id+1);
        else if($id >= 9 && $id < 99) $id = "LOVE_000".($id+1);
        else if($id >= 99 && $id < 999) $id = "LOVE_00".($id+1);
        else if($id >= 999 && $id < 9999) $id = "LOVE_0".($id+1);
        else $id = "LOVE_".($id+1);
        $sql = mysql_query("INSERT INTO love VALUES('$id', '$_SESSION[hifood_id]', '$ids')") or die(mysql_error());
    }
    else {
        $sql = mysql_query("DELETE FROM love WHERE id_user='$_SESSION[hifood_id]' AND id_post='$ids'");
    }
    echo mysql_num_rows(mysql_query("SELECT * FROM love WHERE id_post='$ids'"))." ".mysql_num_rows(mysql_query("SELECT * FROM love WHERE id_user='$_SESSION[hifood_id]' AND id_post='$ids'"));
?>