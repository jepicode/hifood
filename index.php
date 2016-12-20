<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HiFood</title>

        <link rel="stylesheet" href="css/jquery.mobile.min.css">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
        
        <div data-role="page" id="index">
            
            <div class="menu"></div>
        
            <div class="ui-content">
                <div id="header">
                    <div id="left">
                        <div id="menu"></div>
                    </div>
                    <div id="center">
                        <div id="logo"></div>
                    </div>
                    <div id="right">
                        <div id="chat" onclick="window.location='list-chat.php'"></div>
                    </div>
                </div>
                <div id="tabs">
                    <div id="new">
                        Terbaru
                    </div>
                    <div id="best">
                        Disukai
                    </div>
                </div>
                <div id="load-update">
                    Ada 2 kiriman baru
                </div>
                <div id="load-here">
                </div>
                <center>
                    <img src="img/load-ajax.gif" id="load-more-ajax">
                </center>
                <img src="img/load-ajax.gif" id="load-ajax">
            
                <div id="overlay"></div>
                <div id="img-here"></div>
                
                <div id="add-btn" onclick="window.location='add.php'"></div>
                
            </div>
                    
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mobile.min.js"></script>
        <script src="js/check-login.js"></script>
        <script src="js/check-chat.js"></script>
        <script>
            $(document).on("pagebeforecreate",function(event){
                $.ajax({
                   url:"include/splashscreen.php",
                   success:function(splash){
                       if(splash == "yes") {
                           window.location="splash.php";
                       }
                       else {
                           checkLogin();
                       }
                    }
               });
            });
            $(document).on('pagebeforeshow', '[data-role="page"]', function(){ 
                $(".menu").html("<div id='mypanel', data-role='panel'></div>");
                $.ajax({
                    url:"include/menu.php",
                    data:"page=recipe-menu",
                    success: function(data){
                        $("#mypanel").html(data);
                    }
                });

                $.mobile.activePage.find('#mypanel').panel();
                $(document).on('click', '#menu', function(){   
                    $.mobile.activePage.find('#mypanel').panel("open");       
                });
            });
            var type = "new";
            $(document).on("pagebeforeshow","#index",function(){
                tabs();
            });
            $(document).on("pageshow","#index",function(){
                check();
                $("#new").click(function(){
                    type = "new";
                    tabs();
                });
                $("#best").click(function(){
                    type="best";
                    tabs();
                });
                $(document).on("click","#love",function(){
                    var idlove = $(this).attr("class");
                    $.ajax({
                        url:"include/love.php",
                        data:"id="+idlove,
                        success:function(love){
                            var ids = idlove.split(" ");
                            var loves = love.split(" ");
                            $("."+ids[0]).html(loves[0]);
                            if(loves[1] == "1") $("."+ids[0]).addClass("active");
                            else $("."+ids[0]).removeClass("active");
                        }
                    });
                });
                $(document).on("click","#content-image", function(){
                    var id = $(this).attr("class");
                    $.ajax({
                        url:"include/images.php",
                        data:"id="+id,
                        beforeSend:function(){
                            $("#overlay").fadeIn(); 
                        },
                        success:function(images){
                            $("#img-here").show();
                            $("#img-here").html(images);
                        }
                    });
                });
                $("#overlay").click(function(){
                    $("#overlay").hide();
                    $("#img-here").hide();
                });
                $(document).on("click","#load-more",function(){
                    var bongkarClass = $("#load-more").attr("class").split(" ");
                    var first = bongkarClass[0];
                    first = first.split("-");
                    first = first[1];
                    var end = bongkarClass[1];
                    end = end.split("-");
                    end = end[1];
                    var limit = bongkarClass[2];
                    limit = limit.split("-");
                    limit = limit[1];
                    $.ajax({
                        url:"include/load.php",
                        data:"type="+type+"&btn=loadmore&first="+first+"&ends="+end+"&limit="+limit,
                        beforeSend:function(){
                            $("#load-more-ajax").show();
                            $("#load-more").remove();
                        },
                        success:function(load){
                            $("#load-more-ajax").hide();
                            $("#load-here").append(load);
                        }
                    });
                });
                setInterval(function(){
                    var bongkarClass = $("#load-more").attr("class").split(" ");
                    var first = bongkarClass[0];
                    first = first.split("-");
                    first = first[1];
                    $.ajax({
                        url:"include/check-new.php",
                        data:"type=recipe&first="+first,
                        success:function(check){
                            if(check != "0" && type == "new"){
                                $("#load-update").show();
                                $("#load-update").html("Ada "+check+" kiriman baru");
                            }
                        }
                    });
                },3000);
                $(document).on("click","#load-update",function(){
                    $("#new").click();
                    $("#load-update").html('');
                    $("#load-update").hide();
                });
            });
            var tabs = function(){
                if(type == "new"){
                    $("#new").addClass("active");
                    $("#best").removeClass("active");
                }
                else if(type == "best"){
                    $("#new").removeClass("active");
                    $("#best").addClass("active");
                }
                $.ajax({
                    url:"include/load.php",
                    beforeSend:function(){
                        $("#load-here").html('');
                        $("#load-ajax").show();
                    },
                    data:"type="+type,
                    success:function(load){
                        $("#load-ajax").hide();
                        $("#load-here").html(load);
                    }
                });
            }
        </script>
    </body>
</html>