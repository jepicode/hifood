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
    date_default_timezone_set("Asia/Bangkok");
    $date = date("Y:m:d H:i:s");
    $target_dir = "../img/post/";
    $i = 1;
    $img1 = "";
    $img2 = "";
    $img3 = "";
    while($i <= 3){
        if(isset($_FILES["images".$i])) {
            if($_FILES["images".$i]["error"] == 0){
                $imageFileType = pathinfo($_FILES["images".$i]["name"],PATHINFO_EXTENSION);
                if($img1 == "") { $img1 = $id."-1.".$imageFileType; $ids = $img1; }
                else if($img2 == "") { $img2 = $id."-2.".$imageFileType; $ids = $img2; }
                else if($img3 == "") { $img3 = $id."-3.".$imageFileType; $ids = $img3; }
                $imageFileType = pathinfo($_FILES["images".$i]["name"],PATHINFO_EXTENSION);
                $target_file = $target_dir . $ids;
                move_uploaded_file($_FILES["images".$i]["tmp_name"], $target_file);
                require_once("imageResize.php");
                $wmax = 854;
                $hmax = 480;
                imageResize($target_file, $target_file, $wmax, $hmax, $imageFileType);
            }
        }
        $i++;
    }
    $img = "";
    if($img1 != "") $img = $img."img/post/".$img1.",";
    if($img2 != "") $img = $img."img/post/".$img2.",";
    if($img3 != "") $img = $img."img/post/".$img3.",";
    $url = $img;
    
    if(mysql_query("INSERT INTO post VALUES('$id', '$_SESSION[hifood_id]', '$name', '$desc', '', '', '', '', '', '$date', 'food')") && mysql_query("INSERT INTO images VALUES('$id_image','post','$id','','$url')")){
        echo "<script>window.location='../food.php'</script>";
    }
    else {
        echo "<script>window.location='../add-food.php'</script>";
    } 
?>