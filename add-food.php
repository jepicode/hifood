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
                    
            <div class="ui-content">
                <div id="header">
                    <div id="left">
                        <div id="back" onclick="window.location='food.php'"></div>
                    </div>
                    <div id="center">
                        <div id="logo"></div>
                    </div>
                    <div id="right">
                        <div id="chat" onclick="window.location='list-chat.php'"></div>
                    </div>
                </div>
                
                <div id="header-info">
                    Berbagi Makanan
                    <div></div>
                </div>
                
                <div id="form-add">
                    <form action="include/do-add-food.php" method="post" data-ajax="false" enctype="multipart/form-data">
                        <label for="name">Nama Makanan</label>
                        <input type="text" maxlength="50" name="name" id="name" data-role="none" autocomplete="off" placeholder="Nama Makanan Anda">
                        <span id="error" class="errname"></span>
                        <label for="desc">Deskripsi Makanan</label>
                        <textarea id="desc" name="desc" data-role="none" placeholder="Deskripsikan Makanan Anda"></textarea>
                        <span id="error" class="errdesc"></span>
                        <label>Foto Makanan</label>
                        <div id="images-form">
                            <label onclick="$('.filename1').click()" class="images btnfilename1">Unggah Foto</label>
                            <input type="file" name="images1" id="images" class="filename1" data-role="none" accept="image/*">
                            <label id="filename1" style="clear:both; display:block;"></label>
                        </div>
                        <span id="error" class="errimages"></span>
                        <input type="button" value="Tambah" id="add-images" data-role="none">
                        <input type="button" value="Hapus" id="remove-images" data-role="none">
                        <input type="button" value="Bagikan" id="check-btn" data-role="none">
                        <input type="submit" data-role="none" style="display:none" data-ajax="false">
                    </form>
                </div>
                <img src="img/load-ajax.gif" id="load-ajax">
                
            </div>
                    
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mobile.min.js"></script>
        <script src="js/check-login.js"></script>
        <script src="js/autosize.min.js"></script>
        <script src="js/check-chat.js"></script>
        <script>
            autosize($('textarea'));
            $(document).on("pagebeforeshow","#add",function(){
                checkLogin();
                $("#load-ajax").show();
            });
            $(document).on("pageshow","#add",function(){
                check();
                $("#load-ajax").hide();
                var images = 1;
                var langkah = 1;
                if(images == 1)
                    $("#remove-images").hide();
                $("#add-images").click(function(){
                    images++;
                    $("#images-form").append("<label onclick=$('.filename"+images+"').click() class='images btnfilename"+images+"'>Unggah Foto</label><input type='file' name='images"+images+"' id='images' class='filename"+images+"' data-role='none' accept='image/*'><label id='filename"+images+"' style='clear:both; display:block;'></label>");
                    if(images == 3)
                        $("#add-images").hide();
                    $("#remove-images").show();
                });
                $("#remove-images").click(function(){
                    $(".btnfilename"+images).remove();
                    $(".filename"+images).remove();
                    $("#filename"+images).remove();
                    images--;
                    $("#add-images").show();
                    if(images == 1)
                        $("#remove-images").hide();
                });
                $(document).on("change","#images",function(){
                    var file = this.files[0];
                    var id = $(this).attr("class");
                    $("#"+id).html(file.name);
                    if(file.size > 4194304) $(".errimages").html("Foto Makanan maksimal 4MB");
                    else $(".errimages").html("");
                });
                $("#name").change(function(){
                    if($(this).val() == "") 
                        $(".errname").html("Nama Makanan tidak boleh kosong").show();
                    else
                        $(".errname").html('').hide();
                });
                $("#desc").change(function(){
                    if($(this).val() == "")
                        $(".errdesc").html("Deskripsi Makanan tidak boleh kosong").show();
                    else
                        $(".errdesc").html('').hide();
                })
                                
                $("#check-btn").click(function(){
                    if($("#name").val() == "") 
                        $(".errname").html("Nama Makanan tidak boleh kosong").show();
                    else 
                        $(".errname").html('').hide();
                    if($("#desc").val() == "") 
                        $(".errdesc").html("Deskripsi Masakan tidak boleh kosong").show();
                    else
                        $(".errdesc").html('').hide();
                    var i = 1;
                    var imagez = "";
                    var imagesize = false;
                    while(i <= images){
                        if ($('.filename'+images).get(0).files.length === 0) {                            
                        }
                        else {
                            var file = $(".filename"+images)[0].files[0];
                            if(file.size > 4194304) {
                                imagesize = true;
                            }
                            imagez = imagez+""+file.size;
                        }
                        i++;
                    }
                    if(imagez == "" || imagez == null){
                        $(".errimages").html("Foto Makanan tidak boleh kosong").show();
                    }
                    else {
                        if(imagesize == true)
                            $(".errimages").html("Foto Makanan maksimal 4MB").show();
                        else
                            $(".errimages").html('').hide();
                    }
                    if($(".errname").html() == "" && $(".errdesc").html() == "" && $(".errimages").html() == ""){
                        $("input[type=submit]").click();
                    }
                    
                });                
            });
        </script>
    </body>
</html>