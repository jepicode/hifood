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
                        <div id="back" onclick="window.location='index.php'"></div>
                    </div>
                    <div id="center">
                        <div id="logo"></div>
                    </div>
                    <div id="right">
                        <div id="chat" onclick="window.location='list-chat.php'"></div>
                    </div>
                </div>
                
                <div id="header-info">
                    Berbagi Resep Masakan
                    <div></div>
                </div>
                
                <div id="form-add">
                    <form action="include/do-add.php" method="post" data-ajax="false" enctype="multipart/form-data">
                        <label for="name">Nama Masakan</label>
                        <input type="text" maxlength="50" name="name" id="name" data-role="none" autocomplete="off" placeholder="Nama Masakan Anda">
                        <span id="error" class="errname"></span>
                        <label for="desc">Deskripsi Masakan</label>
                        <textarea id="desc" name="desc" data-role="none" placeholder="Deskripsikan Masakan Anda"></textarea>
                        <span id="error" class="errdesc"></span>
                        <div id="bahan-form">
                            <label for="bahan">Bahan-Bahan</label>
                            <input type="text" name="bahan-ke1" id="bahan" data-role="none" placeholder="Bahan ke-1" autocomplete="off">
                        </div>
                        <span id="error" class="errbahan"></span>
                        <input type="text" name="bahan" style="display:none" data-role="none">
                        <input type="button" value="Tambah" id="add-bahan" data-role="none">
                        <input type="button" value="Hapus" id="remove-bahan" data-role="none">
                        <div id="langkah-form">
                            <label for="langkah">Langkah-Langkah</label>
                            <input type="text" name="langkah-ke1" id="langkah" data-role="none" placeholder="Langkah ke-1" autocomplete="off">
                        </div>
                        <span id="error" class="errlangkah"></span>
                        <input type="text" name="langkah" style="display:none" data-role="none">
                        <input type="button" value="Tambah" id="add-langkah" data-role="none">
                        <input type="button" value="Hapus" id="remove-langkah" data-role="none">
                        <label for="serving">Jumlah Porsi per Masakan</label>
                        <input type="number" value="1" name="serving" id="serving" data-role="none" autocomplete="off" maxlength="3">
                        <span id="error" class="errserving"></span>
                        <label>Waktu Memasak</label>
                        <input type="number" value="0" name="jam" id="jam" class="time" data-role="none" autocomplete="off"><span>Jam</span>
                        <input type="number" value="0" name="menit" id="menit" class="time" data-role="none" autocomplete="off"><span>Menit</span>
                        <span id="error" class="errtime"></span>
                        <label>Tingkat Kesulitan</label>
                        <input type="range" min="1" max="5" data-role="none">
                        <div id="level-range"></div>
                        <input type="text" name="level" id="level" readonly data-role="none">
                        <label>Foto Masakan</label>
                        <label for="images">Unggah Foto</label>
                        <label id="filename" style="clear:both; display:block;"></label>
                        <span id="error" class="errimages"></span>
                        <input type="file" name="images" id="images" data-role="none" accept="image/*">
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
                var bahan = 1;
                var langkah = 1;
                if(bahan == 1)
                    $("#remove-bahan").hide();
                $("#add-bahan").click(function(){
                    bahan++;
                    $("#bahan-form").append("<input type='text' name='bahan-ke"+bahan+"' id='bahan' data-role='none' placeholder='Bahan ke-"+bahan+"' autocomplete='off'>");
                    $("#remove-bahan").show();
                });
                $("#remove-bahan").click(function(){
                    $("input[name=bahan-ke"+bahan+"]").remove();
                    bahan--;
                    if(bahan == 1)
                        $("#remove-bahan").hide();
                });
                if(langkah == 1)
                    $("#remove-langkah").hide();
                $("#add-langkah").click(function(){
                    langkah++;
                    $("#langkah-form").append("<input type='text' name='langkah-ke"+langkah+"' id='langkah' data-role='none' placeholder='Langkah ke-"+langkah+"' autocomplete='off'>");
                    $("#remove-langkah").show();
                });
                $("#remove-langkah").click(function(){
                    $("input[name=langkah-ke"+langkah+"]").remove();
                    langkah--;
                    if(langkah == 1)
                        $("#remove-langkah").hide();
                });
                $("#level-range").html("Lumayan");
                $("#level").val("lumayan");
                $("input[type=range]").change(function(){
                    if($(this).val() == "1"){
                        $("#level-range").html("Sangat Mudah");
                        $("#level").val("sangat mudah");
                    }
                    else if($(this).val() == "2"){
                        $("#level-range").html("Mudah");
                        $("#level").val("mudah");
                    }
                    else if($(this).val() == "3"){
                        $("#level-range").html("Lumayan");
                        $("#level").val("lumayan");
                    }
                    else if($(this).val() == "4"){
                        $("#level-range").html("Sulit");
                        $("#level").val("sulit");
                    }
                    else if($(this).val() == "5"){
                        $("#level-range").html("Sangat Sulit");
                        $("#level").val("sangat sulit");
                    }
                });
                
                $("#name").change(function(){
                    if($("#name").val() == "") {
                        $(".errname").html("Nama Masakan tidak boleh kosong");
                        $(".errname").show();
                    }
                    else{
                        $(".errname").html('');
                        $(".errname").hide();
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
                $("#serving").change(function(){
                    if($("#serving").val() == "" || parseInt($("#serving").val()) < 1) {
                        $(".errserving").html("Jumlah Porsi per Masakan tidak boleh kosong");
                        $(".errserving").show();
                    }
                    else{
                        $(".errserving").html('');
                        $(".errserving").hide();
                    }
                });
                $(".time").change(function(){
                    if($("#jam").val() == "" || $("#menit").val() == "") {
                        $(".errtime").html("Waktu Memasak tidak boleh kosong");
                        $(".errtime").show();
                    }
                    else {
                        if($("#jam").val() == "0" && $("#menit").val() == "0") {
                            $(".errtime").html("Waktu Memasak tidak boleh kosong");
                            $(".errtime").show();
                        }
                        else {
                            $(".errtime").html('');
                            $(".errtime").hide();
                        }
                    }
                });
                $("#images").change(function(){
                    var file = this.files[0];
                    $("#filename").html(file.name);
                    if(file.size > 4194304) $(".errimages").html("Foto Masakan maksimal 4MB");
				    else $(".errimages").html("");
                });
                
                $("#check-btn").click(function(){
                    if($("#name").val() == "") {
                        $(".errname").html("Nama Masakan tidak boleh kosong");
                        $(".errname").show();
                    }
                    else {
                        $(".errname").html('');
                        $(".errname").hide();
                    }
                    if($("#desc").val() == "") {
                        $(".errdesc").html("Deskripsi Masakan tidak boleh kosong");
                        $(".errdesc").show();
                    }
                    else {
                        $(".errdesc").html('');
                        $(".errdesc").hide();
                    }
                    var i = 1;
                    var bahan2 = "";
                    while(i <= bahan){
                        if($("input[name=bahan-ke"+i+"]").val() != "") {
                            bahan2 = bahan2+$("input[name=bahan-ke"+i+"]").val()+"|";
                        }
                        i++;
                    }
                    $("input[name=bahan]").val(bahan2);
                    if(bahan2 == ""){
                        $(".errbahan").html("Bahan-Bahan tidak boleh kosong");
                        $(".errbahan").show();
                    }
                    else {
                        $(".errbahan").html('');
                        $(".errbahan").hide();
                    }
                    i = 1;
                    var langkah2 = "";
                    while(i <= langkah){
                        if($("input[name=langkah-ke"+i+"]").val() != "") {
                            langkah2 = langkah2+$("input[name=langkah-ke"+i+"]").val()+"|";
                        }
                        i++;
                    }
                    if(langkah2 == ""){
                        $(".errlangkah").html("Langkah-Langkah tidak boleh kosong");
                        $(".errlangkah").show();
                    }
                    else {
                        $(".errlangkah").html('');
                        $(".errlangkah").hide();
                    }
                    $("input[name=langkah]").val(langkah2);
                    if($("#serving").val() == "" || $("#serving").val() < 1){
                        $(".errserving").html("Jumlah Porsi per Masakan tidak boleh kosong");
                        $(".errserving").show();
                    }
                    else {
                        $(".errserving").html("");
                        $(".errserving").hide();
                    }
                    if($("#jam").val() == "" || $("#menit").val() == "") {
                        $(".errtime").html("Waktu Memasak tidak boleh kosong");
                        $(".errtime").show();
                    }
                    else {
                        if($("#jam").val() == "0" && $("#menit").val() == "0") {
                            $(".errtime").html("Waktu Memasak tidak boleh kosong");
                            $(".errtime").show();
                        }
                        else {
                            $(".errtime").html('');
                            $(".errtime").hide();
                        }
                    }
                    if (($("#images"))[0].files.length > 0) {
                        file_size = ($("#images"))[0].files[0].size;
                        if(file_size > 4194304) $(".errimages").html("Foto Masakan maksimal 4MB");
                        else $(".errimages").html('');
                    } else {
                        $(".errimages").html("Foto Masakan tidak boleh kosong");
                    }
                    if($(".errname").html() == "" && $(".errdesc").html() == "" && $(".errbahan").html() == "" && $(".errlangkah").html() == "" && $(".errserving").html() == "" && $(".errtime").html() == "" && $(".errimages").html() == ""){
                        $("input[type=submit]").click();
                    }
                    
                });                
            });
        </script>
    </body>
</html>