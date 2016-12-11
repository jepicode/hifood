<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HiFood</title>

        <link rel="stylesheet" href="css/jquery.mobile.min.css">
        <link rel="stylesheet" href="css/chat.css">
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
        
        <div data-role="page" id="chats">
            
            <div class="ui-content">
                <div id="header">
                    <div id="left">
                        <div id="back" onclick="window.location='list-chat.php'"></div>
                    </div>
                    <div id="center">
                        <div id="logo"></div>
                    </div>
                    <div id="right">
                        <div></div>
                    </div>
                </div>
                <div id="load-here">
                </div>
                <div id="text">
                    <textarea data-role="none" rows="1"></textarea>
                    <input type="button" value="Kirim" data-role="none">
                </div>
                <center><img src="img/load-ajax.gif" id="load-ajax" style="margin-top:20px"></center>
            
                <div id="overlay"></div>
                <div id="img-here"></div>
                                
            </div>
                    
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mobile.min.js"></script>
        <script src="js/check-browser.js"></script>
        <script src="js/check-login.js"></script>
        <script src="js/url-parameter.js"></script>
        <script src="js/autosize.min.js"></script>
        <script>
            var id = getUrlParameter('id');
            autosize($('textarea'));
            $(document).on("pagebeforecreate",function(event){
                checkBrow();
                checkLogin();
            });
                
            $(document).on('pagebeforeshow', '[data-role="page"]', function(){ 
                $(".menu").html("<div id='mypanel', data-role='panel'></div>");
                $.ajax({
                    url:"include/menu.php",
                    data:"page=chats",
                    success: function(data){
                        $("#mypanel").html(data);
                    }
                });

                $.mobile.activePage.find('#mypanel').panel();
                $(document).on('click', '#menu', function(){   
                    $.mobile.activePage.find('#mypanel').panel("open");       
                });
            });
            $(document).on("pagebeforeshow","#chats",function(){
                update();
                change();
            });
            $(document).on("pageshow","#chats",function(){
                $("textarea").focus();
                $(document).on("click","input[type=button]",function(){
                    if($("textarea").val() != ""){
                        $.ajax({
                            url:"include/send-chat.php",
                            data:"id="+id+"&chat="+$("textarea").val(),
                            success:function(send){
                                $("textarea").val('');
                                window.location='chat.php?id='+id;
                            }
                        });
                    }
                });
                $("textarea").focus(function(){
                    change();
                });
                setInterval(function(){
                    var last = $("#last").attr("class");
                    $.ajax({
                        url:"include/check-new-chat.php",
                        data:"id="+id+"&last="+last,
                        success:function(check){
                            if(check != ""){
                                $("#new-chat").html(check);
                                if($("#divchat").scrollTop() + $("#divchat").height() < $("#divchat")[0].scrollHeight)
                                    $("#new-chat").slideDown();
                                else {
                                    $("#new-chat").slideUp();
                                    update();
                                }
                            }
                        }
                    });
                },3000);
                setInterval(function(){
                    if($("#status").html() == "Terkirim"){
                        $.ajax({
                            url:"include/check-status.php",
                            data:"id="+id,
                            success:function(check){
                                if(check == "read"){
                                    $("#status").html("Dibaca");
                                }
                            }
                        });
                    }
                },3000);
            });
            var update = function(){
                $.ajax({
                    url:"include/chat.php",
                    beforeSend:function(){
                        $("#load-ajax").show();
                    },
                    data:"id="+id,
                    success:function(chat){
                        $("#load-ajax").hide();
                        $("#load-here").html(chat);
                        var height = $(window).height();
                        $("#divchat").height(height-142);
                        $("#divchat").scrollTop($('#divchat')[0].scrollHeight);
                        $("input[type=button]").height($("textarea").height());
                        var tinggi = $("textarea").height();
                        $("textarea").keypress(function(e){
                            if(e.which == 13) return false;                   
                        });
                        $("textarea").keydown(function(){
                            tinggi = $("textarea").height();
                            $("#divchat").height(height-127-tinggi);
                            $("input[type=button]").height($("textarea").height());
                        });
                        $("#new-chat").click(function(){
                            $("#divchat").scrollTop($("#divchat")[0].scrollHeight);
                        });
                                                                        
                    }
                });
            };
            var change = function(){
                $.ajax({
                    url:"include/check-status.php",
                    data:"id="+id+"&set=read",
                    success:function(){
                        
                    }
                })
            }
        </script>
    </body>
</html>