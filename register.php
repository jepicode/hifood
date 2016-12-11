<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HiFood</title>

        <link rel="stylesheet" href="css/jquery.mobile.min.css">
        <link rel="stylesheet" href="css/add.css">
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
        
        <div data-role="page" id="add">
                    
            <div class="menu"></div>
            
            <div class="ui-content">
                <div id="header">
                    <div id="left">
                        <div id="back" onclick="window.location='login.php'"></div>
                    </div>
                    <div id="center">
                        <div id="logo"></div>
                    </div>
                    <div id="right">
                        
                    </div>
                </div>
                
                <div id="header-info">
                    Pendaftaran
                    <div></div>
                </div>
                
                <div id="form-add">
                    <form action="include/add-profile.php" method="post" data-ajax="false" enctype="multipart/form-data">
                        <label for="name">Nama Pengguna</label>
                        <input type="text" maxlength="10" name="name" id="name" data-role="none" autocomplete="off" placeholder="Nama Pengguna">
                        <span id="error" class="errname"></span>
                        <label for="fullname">Nama Lengkap</label>
                        <label for="fullname"></label>
                        <input type="text" maxlength="50" name="fullname" id="fullname" data-role="none" autocomplete="off" placeholder="Nama Lengkap Anda">
                        <span id="error" class="errfullname"></span>
                        <label for="desc">Deskripsi Diri</label>
                        <textarea id="desc" name="desc" data-role="none" placeholder="Deskripsikan Diri Anda"></textarea>
                        <span id="error" class="errdesc"></span>
                        <label>Foto Profil</label>
                        <label for="images">Unggah Foto</label>
                        <label id="filename" style="clear:both; display:block;"></label>
                        <span id="error" class="errimages"></span>
                        <input type="file" name="images" id="images" data-role="none" accept="image/*">
                        <label for="newpass" style="margin-top:10px;">Kata Sandi</label>
                        <input type="password" name="newpass" data-role="none" placeholder="Kata Sandi Anda" id="newpass">
                        <span id="error" class="errnewpass"></span>
                        <label for="comfpass">Konfirmasi Kata Sandi</label>
                        <input type="password" name="comfpass" data-role="none" placeholder="Konfirmasi Kata Sandi" id="comfpass">
                        <span id="error" class="errcomfpass"></span>
                        <input type="button" value="Daftar" id="check-btn" data-role="none" style="background-image:url(img/add-user.png) !important">
                        <input type="submit" data-role="none" style="display:none" data-ajax="false">
                    </form>
                </div>
                <img src="img/load-ajax.gif" id="load-ajax">
                <div id="ajax" style="display:none"></div>
            </div>
                    
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mobile.min.js"></script>
        <script src="js/check-browser.js"></script>
        <script src="js/check-login.js"></script>
        <script src="js/autosize.min.js"></script>
        <script src="js/check-chat.js"></script>
        <script>
            autosize($('textarea'));
            $(document).on("pagebeforecreate",function(){
                checkBrow();
                $.ajax({
                    url:"include/check-login.php",
                    data:"page=login",
                    success:function(login){
                        if(login == "yes")
                            window.location='index.php';
                    }
                });
            });
            $(document).on("pagebeforeshow","#add",function(){
                $("#load-ajax").show();
            });
            $(document).on("pageshow","#add",function(){
                $("#load-ajax").hide();
                
                $("#name").change(function(){
                    if($("#name").val() == "") {
                        $(".errname").html("Nama Pengguna tidak boleh kosong");
                        $(".errname").show();
                    }
                    else{
                        var nama = $("#name").val();
                        $.ajax({
                            url:"include/check-user.php",
                            data:"name="+nama,
                            success:function(check){
                                if(check == "ada") {
                                $(".errname").html("Nama Pengguna sudah dipakai").show();
                                }
                                else
                                    $(".errname").html('').hide();
                            }
                        });
                    }
                });
                $("#fullname").change(function(){
                    if($("#fullname").val() == "") {
                        $(".errfullname").html("Nama Lengkap tidak boleh kosong");
                        $(".errfullname").show();
                    }
                    else{
                        $(".errfullname").html('');
                        $(".errfullname").hide();
                    }
                });
                $("#desc").change(function(){
                    if($("#desc").val() == "") {
                        $(".errdesc").html("Deskripsi Masakan tidak boleh kosong");
                        $(".errdesc").show();
                    }
                    else{
                        $(".errdesc").html('');
                        $(".errdesc").hide();
                    }
                });
                $("#images").change(function(){
                    var file = this.files[0];
                    $("#filename").html(file.name);
                    if(file.size < 0) $(".errimages").html("Foto Profil tidak boleh kosong").show();
                    else if(file.size > 4194304) $(".errimages").html("Foto Profil maksimal 4MB").show();
				    else $(".errimages").html("").hide();
                });
                $("#newpass").change(function(){
                    if($("#newpass").val() == "")
                        $(".errnewpass").html("Kata Sandi tidak boleh kosong").show();
                    else
                        $(".errnewpass").html('').hide();
                });
                $("#comfpass").change(function(){
                    if($("#newpass").val() =="" && $(this).val() != "")
                        $(".errcomfpass").html('Kata Sandi masih kosong').show();
                    else if($(this).val() == "" && $("#newpass").val() != "")
                        $(".errcomfpass").html("Konfirmasi Kata Sandi masih kosong").show();
                    else if($("#newpass").val() != $("#comfpass").val())
                        $(".errcomfpass").html("Konfirmasi Kata Sandi tidak cocok").show();
                    else
                        $(".errcomfpass").html('').hide();
                });
                
                $(document).on("click","#check-btn",function(){
                    if($("#desc").val() == "") {
                        $(".errdesc").html("Deskripsi Diri tidak boleh kosong");
                        $(".errdesc").show();
                    }
                    else {
                        $(".errdesc").html('');
                        $(".errdesc").hide();
                    }
                    if($("#fullname").val() == "")
                        $(".errfullname").html("Nama Lengkap tidak boleh kosong").show();
                    else
                        $(".errfullname").html('').hide();
                    if($("#name").val() == "") {
                        $(".errname").html("Nama Pengguna tidak boleh kosong");
                        $(".errname").show();
                    }
                    else{
                        var nama = $("#name").val();
                        $.ajax({
                            url:"include/check-user.php",
                            data:"name="+nama,
                            success:function(check){
                                if(check == "ada") {
                                $(".errname").html("Nama Pengguna sudah dipakai").show();
                                }
                                else
                                    $(".errname").html('').hide();
                            }
                        });
                    }
                    if($("#newpass").val() == "")
                        $(".errnewpass").html("Kata Sandi tidak boleh kosong").show();
                    else
                        $(".errnewpass").html('').hide();
                    if($("#newpass").val() == "" && $("#comfpass").val() != "") 
                    {
                        $(".errcomfpass").html('Kata Sandi masih kosong').show();
                    }
                    else if($("#comfpass").val() == "" && $("#newpass").val() != "")
                        $(".errcomfpass").html("Konfirmasi Kata Sandi masih kosong").show();
                    else if($("#newpass").val() != $("#comfpass").val())
                        $(".errcomfpass").html("Konfirmasi Kata Sandi tidak cocok").show();
                    else
                        $(".errcomfpass").html('').hide();
                    
                    if (($("#images"))[0].files.length > 0) {
                        file_size = ($("#images"))[0].files[0].size;
                        if(file_size > 4194304) $(".errimages").html("Foto Profil maksimal 4MB").show();
                        else $(".errimages").html('').hide();
                    } 
                    else
                        $(".errimages").html("Foto Profil tidak boleh kosong").show();
                    if($(".errname").html() == "" && $(".errdesc").html() == "" && $(".errfullname").html() == "" && $(".errimages").html() == "" && $(".errnewpass").html() == "" && $(".errcomfpass").html() == ""){
                        $("input[type=submit]").click();
                    }
                    
                });                
            });
        </script>
    </body>
</html>