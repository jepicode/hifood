<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HiFood</title>

        <link rel="stylesheet" href="css/jquery.mobile.min.css">
        <link rel="stylesheet" href="css/profile.css">
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
        
        <div data-role="page" id="profile">
            
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
                        <div id="chat"></div>
                    </div>
                </div>

                <div id="form-search">
                    <input type="text" placeholder="Cari resep masakan atau  makanan..." id="search-box" data-role="none">
                    <input type="button" value="Cari" id="search-button" data-role="none">
                </div>
                <div id="info-post"></div>
                <div id="tabs" style="display:none">
                    <div id="recipe" class="active">Resep Masakan</div>
                    <div id="food">Makanan</div>
                </div>
                <div id="content-data" style="display:none">

                </div>
                <center>
                    <img src="img/load-ajax.gif" id="load-more-ajax">
                </center>
                    
                <img src="img/load-ajax.gif" id="load-ajax">
            
                <div id="overlay"></div>
                <div id="img-here"></div>
                                
            </div>
                    
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mobile.min.js"></script>
        <script src="js/check-login.js"></script>
        <script src="js/autosize.min.js"></script>
        <script src="js/url-parameter.js"></script>
        <script src="js/check-chat.js"></script>
        <script>
            var id = getUrlParameter('id');
            var type = "recipe";
            var search = "";
            $(document).on('pagebeforeshow', '[data-role="page"]', function(){ 
                $(".menu").html("<div id='mypanel', data-role='panel'></div>");
                $.ajax({
                    url:"include/menu.php",
                    data:"page=search-menu",
                    success: function(data){
                        $("#mypanel").html(data);
                    }
                });

                $.mobile.activePage.find('#mypanel').panel();
                $(document).on('click', '#menu', function(){   
                    $.mobile.activePage.find('#mypanel').panel("open");       
                });
            });
            $(document).on("pagebeforeshow","#profile",function(){
                checkLogin();
            });
            $(document).on("pageshow","#profile",function(){
                check();
                $("#search-button").click(function(){
                    search = $("#search-box").val();
                    if(search == "") {
                        $("#content-data").hide();
                        $("#tabs").hide();
                    }
                    else{
                        $("#content-data").show();
                        $("#tabs").show();
                        tabs();
                    }
                });
                $("#search-box").keypress(function(e){
                    if(e.which == 13){
                        search = $("#search-box").val();
                        if(search == "") {
                            $("#content-data").hide();
                            $("#tabs").hide();
                        }
                        else{
                            $("#content-data").show();
                            $("#tabs").show();
                            tabs();
                        }
                    }
                });
                $("#overlay").click(function(){
                    $("#overlay").hide();
                    $("#img-here").hide();
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
                $(document).on("click","#recipe",function(){
                    type="recipe";
                    tabs();
                });
                $(document).on("click","#food",function(){
                    type="food";
                    tabs();
                });
                
            });
            var tabs = function(){
                if(type == "recipe"){
                    $("#recipe").addClass("active");
                    $("#food").removeClass("active");
                }
                else if(type == "food"){
                    $("#recipe").removeClass("active");
                    $("#food").addClass("active");
                }
                if(type == "recipe"){
                    $.ajax({
                        url:"include/load.php",
                        beforeSend:function(){
                            $("#content-data").html('');
                            $("#load-more-ajax").show();
                        },
                        data:"type=new&search="+search,
                        success:function(load){
                            $("#load-more-ajax").hide();
                            $("#content-data").html(load);
                        }
                    });
                }
                else if(type == "food"){
                    $.ajax({
                        url:"include/load-food.php",
                        beforeSend:function(){
                            $("#content-data").html('');
                            $("#load-more-ajax").show();
                        },
                        data:"type=new&search="+search,
                        success:function(load){
                            $("#load-more-ajax").hide();
                            $("#content-data").html(load);
                        }
                    })
                }
                if(type=="recipe"){
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
                }
                else if(type=="food"){
                    $(document).on("click","#content-image", function(){
                        var id = $(this).attr("class").split(" ");
                        id = id[0];
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
                }
            }
        </script>
    </body>
</html>