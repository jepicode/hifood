<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HiFood</title>

        <link rel="stylesheet" href="css/jquery.mobile.min.css">
        <link rel="stylesheet" href="css/login.css">

    </head>
    <body>
        
        <div data-role="page" id="login">
        
            <div class="ui-content">
                <div id="content">
                    <img src="img/logo.png" id="logo">
                    
                </div>
            </div>
            
            <img src="img/background.jpg" id="background" style="display:none">
            
            <div id="form-login">
                <input type="text" id="username" placeholder="Nama Pengguna" data-role="none" autocomplete="off">
                <input type="password" id="password" placeholder="Kata Sandi" data-role="none">
                <div id="error"></div>
                <button type="button" data-role="none" id="submit">Masuk</button>
            </div>
                   
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mobile.min.js"></script>
        <script>
            $(document).on("pagebeforecreate",function(){
                $.ajax({
                    url:"include/check-login.php",
                    data:"page=login",
                    success:function(login){
                        if(login == "yes")
                            window.location='index.php';
                    }
                });
            });
            $(document).on("pagebeforeshow","#login",function(){
                var widthimg = $("#background")[0].naturalWidth;
                var heightimg = $("#background")[0].naturalHeight;
                var width = $(window).width();
                var height = $(window).height();
                var widthnew = width/widthimg;
                var heightnew = height/heightimg;
                $("#login").css({"background":"url(img/background.jpg) center center no-repeat"});
                if(heightimg * widthnew < height) {
                    $("#login").css("background-size","auto "+height+"px");
                }
                else
                    $("#login").css("background-size",width+"px auto");
                    
            });
            $(document).on("pageshow","#login",function(){
                $("#username").change(function(){
                    if($("#username").val() == ""){
                        $("#error").html("Nama Pengguna belum diisi");
                        $("#error").slideDown();
                    }
                    else {
                        $("#error").html("");
                        $("#error").slideUp();
                    }
                });
                $("#password").change(function(){
                    if($("#password").val() == ""){
                        $("#error").html("Kata Sandi belum diisi");
                        $("#error").slideDown();
                    }
                    else {
                        $("#error").html("");
                        $("#error").slideUp();
                    }
                });
                $("#submit").click(function(){
                    check();
                });
                $(document).keypress(function(e){
                    if(e.which == 13)
                        check();
                });
                var check = function(){
                    var user = $("#username").val();
                    var pass = $("#password").val();
                    if(user == "") {
                        $("#error").html("Nama Pengguna belum diisi");
                        $("#error").slideDown();
                    }
                    else if(pass == ""){
                        $("#error").html("Kata Sandi belum diisi");
                        $("#error").slideDown();
                    }
                    else {
                        $.ajax({
                            url:"include/check-login.php",
                            data:"page=login&check=true&user="+user+"&pass="+pass,
                            success:function(login){
                                if(login == "yes") {
                                    window.location='index.php';
                                    $("#error").html('');
                                    $("#error").slideUp();
                                }
                                else {
                                    $("#error").html("Nama Pengguna dan Kata Sandi tidak cocok");
                                    $("#error").slideDown();
                                }
                            }
                        });
                    }
                }
            });
        </script>
    </body>
</html> 