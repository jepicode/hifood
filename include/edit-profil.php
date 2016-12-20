<?php
    require_once("connect.php");
    require_once("str_replace.php");
    $sql = mysql_query("SELECT * FROM user WHERE id_user='$_SESSION[hifood_id]'");
    $r = mysql_fetch_array($sql);
    $sql1 = mysql_query("SELECT * FROM images WHERE id_user='$_SESSION[hifood_id]'");
    $r1 = mysql_fetch_array($sql1);
    $name = replace($_POST['fullname']);
    $desc = replace($_POST['desc']);
    $pass = md5($_POST['pass']);
    if($_POST['newpass'] != "")
        $pass = md5($_POST['newpass']);
    $id = $r['id_user'];
    if($_FILES['images']['error'] == 0){
        $target_dir = "../img/user/";
        $urldelete = "../".$r1['url'];
        unlink($urldelete);
        $imageFileType = pathinfo($_FILES["images"]["name"],PATHINFO_EXTENSION);
        $target_file = $target_dir . $id . "." .  $imageFileType;
        $url = 'img/user/'.$id.'.'.$imageFileType;
        move_uploaded_file($_FILES["images"]["tmp_name"], $target_file);
    }
    else 
        $url = $r1['url'];
    
    if(mysql_query("UPDATE user SET fullname='$name', description='$desc', password='$pass' WHERE id_user='$id'") && mysql_query("UPDATE images SET url='$url' WHERE id_images='$r1[id_images]'")){
       echo "<script>window.location='../profile.php'</script>";
    }
    else {
        echo "<script>window.location='../edit-profile.php'</script>";
    }
?>