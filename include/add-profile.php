<?php
    require_once("connect.php");
    require_once("str_replace.php");
    $sql = mysql_query("SELECT * FROM user ORDER BY id_user DESC LIMIT 1");
    $r = mysql_fetch_array($sql);
    $id_user = explode("_",$r['id_user']);
    $id_user = $id_user[1];
    if($id_user >= 0 && $id_user < 9) $id_user = "USER_0000".((int)$id_user+1); 
    else if($id_user >= 9 && $id_user < 99) $id_user = "USER_000".((int)$id_user+1);
    else if($id_user >= 99 && $id_user < 999) $id_user = "USER_00".((int)$id_user+1);
    else if($id_user >= 999 && $id_user < 9999) $id_user = "USER_0".((int)$id_user+1);
    else $id_user = "USER_".((int)$id_user+1);
    $sql1 = mysql_query("SELECT * FROM images ORDER BY id_images DESC LIMIT 1");
    $r1 = mysql_fetch_array($sql1);
    $id_images = explode("_",$r1['id_images']);
    $id_images = $id_images[1];
    if($id_images >= 0 && $id_images < 9) $id_images = "IMG_0000".((int)$id_images+1); 
    else if($id_images >= 9 && $id_images < 99) $id_images = "IMG_000".((int)$id_images+1);
    else if($id_images >= 99 && $id_images < 999) $id_images = "IMG_00".((int)$id_images+1);
    else if($id_images >= 999 && $id_images < 9999) $id_images = "IMG_0".((int)$id_images+1);
    else $id_images = "IMG_".((int)$id_images+1);
    $name = replace($_POST['name']);
    $fullname = replace($_POST['fullname']);
    $desc = replace($_POST['desc']);
    $pass = md5($_POST['newpass']);
    if($_FILES['images']['error'] == 0){
        $target_dir = "../img/user/";
        $imageFileType = pathinfo($_FILES["images"]["name"],PATHINFO_EXTENSION);
        $target_file = $target_dir . $id_user . "." .  $imageFileType;
        $url = 'img/user/'.$id_user.'.'.$imageFileType;
        move_uploaded_file($_FILES["images"]["tmp_name"], $target_file);
        require_once("imageResize.php");
        $wmax = 854;
        $hmax = 480;
        imageResize($target_file, $target_file, $wmax, $hmax, $imageFileType);
    }
    
    if(mysql_query("INSERT INTO user VALUES('$id_user', '$name', '$pass', '$fullname', '$desc', 'user', 'no')") && mysql_query("INSERT INTO images VALUES('$id_images', 'user', '', '$id_user', '$url')")){
       echo "<script>window.location='../login.php'</script>";
    }
    else {
        echo "<script>window.location='../register.php'</script>";
    }
?>