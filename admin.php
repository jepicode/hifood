<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HiFood</title>

        <link rel="stylesheet" href="css/jquery.mobile.min.css">
        <link rel="stylesheet" href="css/admin.css">
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
        
        <div data-role="page" id="admin">
            
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
                <div id="admins" style="text-align:center; margin-top:80px;">
                    <h1>Administrator HiFood</h1>
                    <div id="contents">
                        <select id="select" data-role="none">
                            <option value="user">Pengguna</option>
                            <option value="post">Resep Masakan / Makanan</option>
                            <option value="comment">Komentar</option>
                            <option value="chat">Percakapan</option>
                        </select>
                        <div id="load-here">
                        </div>
                    </div>
                </div>
                
            </div>
                    
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mobile.min.js"></script>
        <script src="js/check-browser.js"></script>
        <script src="js/check-login.js"></script>
        <script src="js/check-chat.js"></script>
        <script src="js/url-parameter.js"></script>
        <script>
            var type = getUrlParameter("type");
            var dos = getUrlParameter("dos");
            var id = getUrlParameter("id");
            var page = getUrlParameter("page");
            $(document).on('pagebeforeshow', '[data-role="page"]', function(){ 
                checkBrow();
                $(".menu").html("<div id='mypanel', data-role='panel'></div>");
                $.ajax({
                    url:"include/menu.php",
                    data:"page=admin-menu",
                    success: function(data){
                        $("#mypanel").html(data);
                    }
                });

                $.mobile.activePage.find('#mypanel').panel();
                $(document).on('click', '#menu', function(){   
                    $.mobile.activePage.find('#mypanel').panel("open");       
                });
            });
            $(document).on("pagebeforeshow","#admin",function(){
                $("#select").change(function(){
                    window.location = 'admin.php?type='+$("#select").val();
                });
                if(type != null)
                    $("#select").val(type);
                checkLogin();
                load();
            });
            $(document).on("pageshow","#admin",function(){
                check();
            });
            var load = function(){
                var type = $("#select").val();
                if(dos != null && id != null)
                    var datanya = "type="+type+"&dos="+dos+"&id="+id;
                else {
                    if(page == null)
                        page = 1;
                    var datanya = "type="+type+"&page="+page;
                }
                $.ajax({
                    url:"include/admin.php",
                    data:datanya,
                    success:function(load){
                        $("#load-here").html(load);
                    }
                })
            }
        </script>
    </body>
</html