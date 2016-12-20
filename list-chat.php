<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HiFood</title>

        <link rel="stylesheet" href="css/jquery.mobile.min.css">
        <link rel="stylesheet" href="css/list-chat.css">
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
        
        <div data-role="page" id="list-chat" style="background:#fff !important">
            
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
                        <div></div>
                    </div>
                </div>
                <div id="title-header">
                    Percakapan
                    <div></div>
                </div>
                <div id="load-here">
                    "hello world"
                </div>
                <img src="img/load-ajax.gif" id="load-ajax">
            
                <div id="overlay"></div>
                <div id="img-here"></div>
                
                <div id="add-btn" onclick="window.location='add.php'"></div>
                
            </div>
                    
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mobile.min.js"></script>
        <script src="js/check-login.js"></script>
        <script>
            $(document).on('pagebeforeshow', '[data-role="page"]', function(){ 
                $(".menu").html("<div id='mypanel', data-role='panel'></div>");
                $.ajax({
                    url:"include/menu.php",
                    data:"page=chat-menu",
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
            $(document).on("pagebeforeshow","#list-chat",function(){
                checkLogin();
                tabs();
            });
            $(document).on("pageshow","#list-chat",function(){
                setInterval(function(){
                    $.ajax({
                        url:"include/check-new-chat.php",
                        data:"for=listchat",
                        success:function(check){
                            if(parseInt(check) > 0){
                                tabs();
                            }
                        }
                    });
                },3000);
            });
            var tabs = function(){
                $.ajax({
                    url:"include/list-chat.php",
                    beforeSend:function(){
                        $("#load-here").html('');
                        $("#load-ajax").show();
                    },
                    success:function(load){
                        $("#load-ajax").hide();
                        $("#load-here").html(load);
                    }
                });
            }
        </script>
    </body>
</html>