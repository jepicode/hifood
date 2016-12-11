<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HiFood</title>

        <link rel="stylesheet" href="css/jquery.mobile.min.css">
        <link rel="stylesheet" href="css/splash.css">

    </head>
    <body>
        
        <div data-role="page" id="splash1">
        
            <div class="ui-content">
                <div id="title" style="margin-top:20px !important">Bagikan Resep Kreasimu Disini</div>
                <div id="image1">
                    
                </div>
                <div id="dots">
                    <div id="dots1" class="active"></div>
                    <div id="dots2" onclick="$('#splash1tosplash2').click();"></div>
                    <div id="dots3" onclick="$('#splash1tosplash3').click();"></div>
                </div>
            </div>
            <a href="#splash2" data-direction="right" data-transition="slide" id="splash1tosplash2"></a>
            <a href="#splash3" data-direction="right" data-transition="slide" id="splash1tosplash3"></a>
        
        </div>
        
        <div data-role="page" id="splash2">
        
            <div class="ui-content">
                <div id="title" style="margin-top:20px !important">Serta Makananmu</div>
                <div id="image2">
                    
                </div>
                <div id="dots">
                    <div id="dots1" onclick="$('#splash2tosplash1').click();"></div>
                    <div id="dots2" class="active"></div>
                    <div id="dots3" onclick="$('#splash2tosplash3').click();"></div>
                </div>
            </div>
            <a href="#splash1" data-direction="reverse" data-transition="slide" id="splash2tosplash1"></a>
            <a href="#splash3" data-direction="right" data-transition="slide" id="splash2tosplash3"></a>
        
        </div>
        
        <div data-role="page" id="splash3">
        
            <div class="ui-content">
                <div id="title" style="margin-top:20px">Jangan Malu Bertanya</div>
                <div id="image3">
                    
                </div>
                <div id="next" onclick="window.location='index.php'">Lanjut &gt;&gt;</div>
                <div id="dots">
                    <div id="dots1" onclick="$('#splash3tosplash1').click();"></div>
                    <div id="dots2" onclick="$('#splash3tosplash2').click();"></div>
                    <div id="dots3" class="active"></div>
                </div>
            </div>
            <a href="#splash1" data-direction="reverse" data-transition="slide" id="splash3tosplash1"></a>
            <a href="#splash2" data-direction="reverse" data-transition="slide" id="splash3tosplash2"></a>
        
        </div>
        
        <style>
        </style>
        
        <a href="index.php" data-transition="slideup" id="to-index"></a>

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mobile.min.js"></script>
        <script>
            $(document).on("pagebeforeshow","#splash1",function(){
                $("#image1").height($(window).height() * 80/100);
                $("#image1").width($(window).width());
                $("#image1").css({
                    "background":"url(img/recipe-hh.png?t=<?php echo rand()?>) no-repeat center center",
                    "background-size":"auto "+(($(window).height()*80/100)+75)+"px",
                    "margin-left":"-"+$("#image1").width()/2+"px",
                    "margin-top":"-"+$("#image1").height()/2+"px",
                });
            });
            $(document).on("pageshow","#splash1",function(){
                $("#splash1").on("swipeleft",function(){
                    $("#splash1tosplash2").click();
                });
            });
            $(document).on("pagebeforeshow","#splash2",function(){
                $("#image2").height($(window).height() * 80/100);
                $("#image2").width($(window).width());
                $("#image2").css({
                    "background":"url(img/food-hh.png?t=<?php echo rand()?>) no-repeat center center",
                    "background-size":"auto "+(($(window).height()*80/100)+75)+"px",
                    "margin-left":"-"+$("#image2").width()/2+"px",
                    "margin-top":"-"+$("#image2").height()/2+"px",
                });
            });
            $(document).on("pageshow","#splash2",function(){
                $("#splash2").on("swipeleft",function(){
                    $("#splash2tosplash3").click();
                });
                $("#splash2").on("swiperight",function(){
                    $("#splash2tosplash1").click();
                });
            });
            $(document).on("pagebeforeshow","#splash3",function(){
                $("#image3").height($(window).height() * 80/100);
                $("#image3").width($(window).width());
                $("#image3").css({
                    "background":"url(img/chat-hh.png?t=<?php echo rand()?>) no-repeat center center",
                    "background-size":"auto "+(($(window).height()*80/100)+75)+"px",
                    "margin-left":"-"+$("#image3").width()/2+"px",
                    "margin-top":"-"+$("#image3").height()/2+"px",
                });
            });
            $(document).on("pageshow","#splash3",function(){
                $("#splash3").on("swipeleft",function(){
                    window.location='index.php';
                });
                $("#splash3").on("swiperight",function(){
                    $("#splash3tosplash2").click();
                });
            });
        </script>
    </body>
</html>