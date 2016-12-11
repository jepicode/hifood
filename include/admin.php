<?php
require("connect.php");

if(isset($_GET['type'])){
    if(isset($_GET['id']) && isset($_GET['dos'])){
        if($_GET['type'] == "user"){
            if($_GET['dos'] == "admin"){
                $sql = mysql_query("SELECT * FROM user WHERE id_user='$_GET[id]'");
                if(mysql_num_rows($sql) != 0){
                    $r = mysql_fetch_array($sql);
                    if($r['role'] == "admin")
                        $role = "user";
                    else
                        $role = "admin";
                    if(mysql_query("UPDATE user SET role='$role' WHERE id_user='$_GET[id]'"))
                        echo "<script>window.location='admin.php?type=user'</script>";
                }
                else
                    echo "<script>window.location='admin.php?type=user'</script>";
            }
            if($_GET['dos'] == "delete"){
                $sql = mysql_query("SELECT * FROM user WHERE id_user='$_GET[id]'");
                if(mysql_num_rows($sql) != 0){
                    $sql1 = mysql_query("SELECT * FROM images WHERE id_user='$_GET[id]'");
                    $r1 = mysql_fetch_array($sql1);
                    $url = "../".$r1['url'];
                    if(mysql_query("DELETE FROM user WHERE id_user='$_GET[id]'") && unlink($url) && mysql_query("DELETE FROM images WHERE id_user='$_GET[id]'") && mysql_query("DELETE FROM love WHERE id_user='$_GET[id]'") && mysql_query("DELETE FROM comment WHERE id_user='$_GET[id]'"))
                        echo "<script>window.location='admin.php?type=user'</script>";
                }
                else
                    echo "<script>window.location='admin.php?type=user'</script>";
            }
        }
        else if($_GET['type'] == "post"){
            if($_GET['dos'] == "delete"){
                $sql = mysql_query("SELECT * FROM post WHERE id_post='$_GET[id]'");
                if(mysql_num_rows($sql) != 0){
                    $r = mysql_fetch_array($sql);
                    $sql1 = mysql_query("SELECT * FROM images WHERE id_post='$_GET[id]'");
                    $r1 = mysql_fetch_array($sql1);
                    $sql2 = mysql_query("SELECT * FROM comment WHERE id_post='$_GET[id]'");
                    $sql3 = mysql_query("SELECT * FROM love WHERE id_post='$_GET[id]'");
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
                    if(mysql_num_rows($sql2) > 0)
                        mysql_query("DELETE FROM comment WHERE id_post='$_GET[id]'");
                    if(mysql_num_rows($sql3) > 0)
                        mysql_query("DELETE FROM love WHERE id_post='$_GET[id]'");
                    mysql_query("DELETE FROM images WHERE id_post='$_GET[id]'");
                    if(mysql_query("DELETE FROM post WHERE id_post='$_GET[id]'"))
                        echo "<script>window.location='admin.php?type=post'</script>";  
                }
                else
                    echo "<script>window.location='admin.php?type=post'</script>";
            }
        }
        else if($_GET['type'] == "comment"){
            if($_GET['dos'] == "delete"){
                $sql = mysql_query("SELECT * FROM comment WHERE id_comment='$_GET[id]'");
                if(mysql_num_rows($sql) != 0){
                    if(mysql_query("DELETE FROM comment WHERE id_comment='$_GET[id]'"))
                        echo "<script>window.location='admin.php?type=comment'</script>";
                }
                else
                    echo "<script>window.location='admin.php?type=comment'</script>";
            }
        }
        else if($_GET['type'] == "chat"){
            if($_GET['dos'] == "delete"){
                $sql = mysql_query("SELECT * FROM chat WHERE id_chat='$_GET[id]'");
                if(mysql_num_rows($sql) != 0){
                    if(mysql_query("DELETE FROM chat WHERE id_chat='$_GET[id]'"))
                        echo "<script>window.location='admin.php?type=chat'</script>";
                }
                else
                    echo "<script>window.location='admin.php?type=chat'</script>";
            }
        }
    }
    else {
        if($_GET['type'] == "post"){
            if(isset($_GET['page']))
                $page = $_GET['page'];
            else
                $page = 1;
            $ofset = ($page-1)*10;
            $sql = mysql_query("SELECT * FROM post ORDER BY id_post DESC LIMIT $ofset,10");
?>
<table>
    <tr>
        <th>No</th>
        <th>ID Post</th>
        <th>ID Pengguna</th>
        <th>Nama Masakan</th>
        <th>Deskripsi</th>
        <th>Bahan-bahan</th>
        <th>Langkah-langkah</th>
        <th>Porsi Per Masakan</th>
        <th>Waktu Memasak</th>
        <th>Level Memasak</th>
        <th>Tanggal</th>
        <th>Tipe</th>
        <th>Aksi</th>
    </tr>
<?php
        $i = 1;
        while($r = mysql_fetch_array($sql)){
            if($i % 2 == 0)
                echo "<tr class='even'>";
            else
                echo "<tr class='odd'>";
            echo "<td>$i</td>";
            echo "<td>$r[id_post]</td>";
            echo "<td>$r[id_user]</td>";
            echo "<td>$r[cooking_name]</td>";
            echo "<td>".substr($r['post'],0,100)."...</td>";
            echo "<td>".substr($r['ingredients'],0,100)."...</td>";
            echo "<td>".substr($r['recipes'],0,100)."...";
            echo "<td>$r[serving]</td>";
            echo "<td>$r[cooking_time]</td>";
            echo "<td>$r[cooking_level]</td>";
            echo "<td>$r[date]</td>";
            echo "<td>$r[type]</td>";
            echo "<td id='delete-btn' class='$r[id_post]'><div>Hapus</div></td>";
            echo "</tr>";
            echo "<script>$('.$r[id_post]').click(function(){
                $('#overlay').show(); $('#dialog').show();
                $('#yes').click(function(){
                    window.location = 'admin.php?type=post&dos=delete&id=$r[id_post]';
                });
                $('#no').click(function(){
                    $('#overlay').hide();
                    $('#dialog').hide();
                });
                $('#overlay').click(function(){
                    $('#overlay').hide();
                    $('#dialog').hide();
                });
            })</script>";
            $i++;
        }
?>
</table>
<?php
            $sql = mysql_query("SELECT * FROM user");
            $size = mysql_num_rows($sql)/10;
            $size = ceil($size);
            $i = 1;
            echo "<div id='paging'><div id='pagings'>";
            while($i <= $size){
                if($i == $page){
                    ?><div class="active-page" onclick="window.location='admin.php?type=post&page=<?php echo $i?>'"><?php echo $i?></div><?php
                }
                else {
                    ?><div onclick="window.location='admin.php?type=post&page=<?php echo $i?>'"><?php echo $i?></div><?php
                }
                $i++;
            }
            echo "</div></div>";
        }
        else if($_GET['type'] == "comment"){
            if(isset($_GET['page']))
                $page = $_GET['page'];
            else
                $page = 1;
            $ofset = ($page-1)*10;
            $sql = mysql_query("SELECT * FROM comment ORDER BY id_comment DESC LIMIT $ofset, 10");
?>
<table>
    <tr>
        <th>No</th>
        <th>ID Komentar</th>
        <th>ID Pengguna</th>
        <th>ID Post</th>
        <th>Komentar</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>
<?php
        $i = 1;
        while($r = mysql_fetch_array($sql)){
            if($i % 2 == 0)
                echo "<tr class='even'>";
            else
                echo "<tr class='odd'>";
            echo "<td>$i</td>";
            echo "<td>$r[id_comment]</td>";
            echo "<td>$r[id_user]</td>";
            echo "<td>$r[id_post]</td>";
            echo "<td>".substr($r['comment'],0,100)."...</td>";
            echo "<td>$r[date]</td>";
            echo "<td id='delete-btn' class='$r[id_comment]'><div>Hapus</div></td>";
            echo "</tr>";
            echo "<script>$('.$r[id_comment]').click(function(){
                $('#overlay').show(); $('#dialog').show();
                $('#yes').click(function(){
                    window.location = 'admin.php?type=comment&dos=delete&id=$r[id_comment]';
                });
                $('#no').click(function(){
                    $('#overlay').hide();
                    $('#dialog').hide();
                });
                $('#overlay').click(function(){
                    $('#overlay').hide();
                    $('#dialog').hide();
                });
            })</script>";
            $i++;
        }
?>
</table>
<?php
            $sql = mysql_query("SELECT * FROM comment");
            $size = mysql_num_rows($sql)/10;
            $size = ceil($size);
            $i = 1;
            echo "<div id='paging'><div id='pagings'>";
            while($i <= $size){
                if($i == $page){
                    ?><div class="active-page" onclick="window.location='admin.php?type=comment&page=<?php echo $i?>'"><?php echo $i?></div><?php
                }
                else {
                    ?><div onclick="window.location='admin.php?type=comment&page=<?php echo $i?>'"><?php echo $i?></div><?php
                }
                $i++;
            }
            echo "</div></div>";
        }
        else if($_GET['type'] == "chat"){
            if(isset($_GET['page']))
                $page = $_GET['page'];
            else
                $page = 1;
            $ofset = ($page-1)*10;
            $sql = mysql_query("SELECT * FROM chat ORDER BY id_chat DESC LIMIT $ofset,10");
?>
<table>
    <tr>
        <th>No</th>
        <th>ID Chat</th>
        <th>Dari ID Pengguna</th>
        <th>Ke ID Pengguna</th>
        <th>Pesan</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>
<?php
        $i = 1;
        while($r = mysql_fetch_array($sql)){
            if($i % 2 == 0)
                echo "<tr class='even'>";
            else
                echo "<tr class='odd'>";
            echo "<td>".($i+(10*($_GET['page']-1)))."</td>";
            echo "<td>$r[id_chat]</td>";
            echo "<td>$r[id_user]</td>";
            echo "<td>$r[to_id_user]</td>";
            echo "<td>".substr($r['chat'],0,100)."...</td>";
            echo "<td>$r[date]</td>";
            echo "<td id='delete-btn' class='$r[id_chat]'><div>Hapus</div></td>";
            echo "</tr>";
            echo "<script>$('.$r[id_chat]').click(function(){
                $('#overlay').show(); $('#dialog').show();
                $('#yes').click(function(){
                    window.location = 'admin.php?type=chat&dos=delete&id=$r[id_chat]';
                });
                $('#no').click(function(){
                    $('#overlay').hide();
                    $('#dialog').hide();
                });
                $('#overlay').click(function(){
                    $('#overlay').hide();
                    $('#dialog').hide();
                });
            })</script>";
            $i++;
        }
?>
</table>
<?php
            $sql = mysql_query("SELECT * FROM chat");
            $size = mysql_num_rows($sql)/10;
            $size = ceil($size);
            $i = 1;
            echo "<div id='paging'><div id='pagings'>";
            while($i <= $size){
                if($i == $page){
                    ?><div class="active-page" onclick="window.location='admin.php?type=chat&page=<?php echo $i?>'"><?php echo $i?></div><?php
                }
                else {
                    ?><div onclick="window.location='admin.php?type=chat&page=<?php echo $i?>'"><?php echo $i?></div><?php
                }
                $i++;
            }
            echo "</div></div>";
        }
        else if($_GET['type'] == "user"){
            if(isset($_GET['page']))
                $page = $_GET['page'];
            else
                $page = 1;
            $ofset = ($page-1)*10;
            $sql = mysql_query("SELECT * FROM user ORDER BY id_user ASC LIMIT $ofset,10");
?>
<table>
    <tr>
        <th>No</th>
        <th>ID Pengguna</th>
        <th>Nama Pengguna</th>
        <th>Nama Lengkap</th>
        <th>Deskripsi Diri</th>
        <th colspan="2">Aksi</th>
    </tr>
<?php
        $i = 1;
        while($r = mysql_fetch_array($sql)){
            if($i % 2 == 0)
                echo "<tr class='even'>";
            else
                echo "<tr class='odd'>";
            echo "<td>$i</td>";
            echo "<td>$r[id_user]</td>";
            echo "<td>$r[username]</td>";
            echo "<td>$r[fullname]</td>";
            echo "<td>".substr($r['description'],0,100)."...</td>";
            if($r['role'] == "admin"){
            ?>
                <td id="admin-btn" class="admin"><div onclick="window.location='admin.php?type=user&dos=admin&id=<?php echo $r['id_user']?>'">Admin</div></td>
            <?php
            }
            else {
            ?>
                <td id="admin-btn"><div onclick="window.location='admin.php?type=user&dos=admin&id=<?php echo $r['id_user']?>'">Admin</div></td>
            <?php
            }
            echo "<td id='delete-btn' class='$r[id_user]'><div>Hapus</div></td>";
            echo "</tr>";
            echo "<script>$('.$r[id_user]').click(function(){
                $('#overlay').show(); $('#dialog').show();
                $('#yes').click(function(){
                    window.location = 'admin.php?type=user&dos=delete&id=$r[id_user]';
                });
                $('#no').click(function(){
                    $('#overlay').hide();
                    $('#dialog').hide();
                });
                $('#overlay').click(function(){
                    $('#overlay').hide();
                    $('#dialog').hide();
                });
            })</script>";
            $i++;
        }
?>
</table>
<?php
            $sql = mysql_query("SELECT * FROM user");
            $size = mysql_num_rows($sql)/10;
            $size = ceil($size);
            $i = 1;
            echo "<div id='paging'><div id='pagings'>";
            while($i <= $size){
                if($i == $page){
                    ?><div class="active-page" onclick="window.location='admin.php?type=user&page=<?php echo $i?>'"><?php echo $i?></div><?php
                }
                else {
                    ?><div onclick="window.location='admin.php?type=user&page=<?php echo $i?>'"><?php echo $i?></div><?php
                }
                $i++;
            }
            echo "</div></div>";
        }
    }
}
else
    echo "<script>window.location='index.php'</script>";
?>
<div id="overlay"></div>
<div id="dialog">
    <b>Anda yakin ingin menghapus?</b>
    <div id="yes">Ya</div>
    <div id="no">Tidak</div>
</div>
