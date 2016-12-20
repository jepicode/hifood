<?php
    require_once("connect.php");
    require_once("str_replace.php");
    $sql = mysql_query("SELECT * FROM post ORDER BY id_post DESC LIMIT 1");
    $r = mysql_fetch_array($sql);
    $sql1 = mysql_query("SELECT * FROM images ORDER BY id_images DESC LIMIT 1");
    $r1 = mysql_fetch_array($sql1);
    $id = explode("_",$r['id_post']);
    $id = (int)$id[1];
    $id_image = explode("_", $r1['id_images']);
    $id_image = (int)$id_image[1];
    if($id >= 0 && $id < 9) $id = "POST_0000".($id+1);
    else if($id >= 9 && $id < 99) $id = "POST_000".($id+1);
    else if($id >= 99 && $id < 999) $id = "POST_00".($id+1);
    else if($id >= 999 && $id < 9999) $id = "POST_0".($id+1);
    else $id = "POST_".($id+1);
    if($id_image >= 0 && $id_image < 9) $id_image = "IMG_0000".($id_image+1);
    else if($id_image >= 9 && $id_image < 99) $id_image = "IMG_000".($id_image+1);
    else if($id_image >= 99 && $id_image < 999) $id_image = "IMG_00".($id_image+1);
    else if($id_image >= 999 && $id_image < 9999) $id_image = "IMG_0".($id_image+1);
    else $id_image = "IMG_".($id_image+1);
    $name = replace($_POST['name']);
    $desc = replace($_POST['desc']);
    $bahan = str_replace("|",",",replace($_POST['bahan']));
    $langkah = str_replace("|",",",replace($_POST['langkah']));
    $serving = $_POST['serving'];
    if((int)$_POST['jam'] < 10) $jam = "0".$_POST['jam'];
    else {
        if((int)$_POST['jam'] < 60) $jam = $_POST['jam'];
        else $jam = 60;
    }
    if((int)$_POST['menit'] < 10) $menit = "0".$_POST['menit'];
    else {
        if((int)$_POST['menit'] < 60) $menit = $_POST['menit'];
        else $menit = 60;
    }
    $time = $jam.":".$menit.":00";
    $level = $_POST['level'];
    date_default_timezone_set("Asia/Bangkok");
    $date = date("Y:m:d H:i:s");
    $target_dir = "../img/post/";
	$imageFileType = pathinfo($_FILES["images"]["name"],PATHINFO_EXTENSION);
	$target_file = $target_dir . $id . "." .  $imageFileType;
    $url = 'img/post/'.$id.'.'.$imageFileType;
    
    if(mysql_query("INSERT INTO post VALUES('$id', '$_SESSION[hifood_id]', '$name', '$desc', '$bahan', '$langkah', '$serving', '$time', '$level', '$date', 'recipe')") && mysql_query("INSERT INTO images VALUES('$id_image','post','$id','','$url')") && move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)){
        echo "<script>window.location='../index.php'</script>";
    }
    else {
        echo "<script>window.location='../add.php'</script>";
    }
?>