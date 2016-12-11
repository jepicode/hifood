<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HiFood</title>

        <link rel="stylesheet" href="css/jquery.mobile.min.css">
        <link rel="stylesheet" href="css/detail.css">
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
        
        <div data-role="page" id="detail">
            
            <div class="ui-content">
                <div id="header">
                    <div id="left">
                        <div id="back" onclick="window.location='index.php'"></div>
                    </div>
                    <div id="center">
                        <div id="logo"></div>
                    </div>
                    <div id="right">
                        <div id="delete"></div>
                    </div>
                </div>

                <div id="load-here">
                </div>
                <div id="comments" style="display:none">
                    <div id="header-comment">
                        Komentar
                    </div>
                    <div id="content-comment">
                        
                    </div>
                    <center>
                        <img src="img/load-ajax.gif" id="load-more-ajax">
                    </center>
                    <div id="form">
                        <textarea placeholder="Komentar Disini" data-role="none"></textarea>
                        <button type="button" data-role="none">Kirim Komentar</button>
                    </div>
                </div>
                <img src="img/load-ajax.gif" id="load-ajax">
            
                <div id="overlay"></div>
                <div id="img-here"></div>
                
                <div id="dialog-box">
                    <div id="header-dialog">
                        Apakah anda yakin ingin menghapus Resep Masakan ini?
                    </div>
                    <div id="yesno-dialog">
                        <div id="yes">Ya</div>
                        <div id="no">Tidak</div>
                    </div>
                </div>
                                
            </div>
                    
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mobile.min.js"></script>
        <script src="js/check-browser.js"></script>
        <script src="js/check-login.js"></script>
        <script src="js/autosize.min.js"></script>
        <script src="js/url-parameter.js"></script>
        <script>
            var id = getUrlParameter('id');
            
            $(document).on('pagebeforeshow', '[data-role="page"]', function(){ 
                checkBrow();
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
            $(document).on("pagebeforeshow","#detail",function(){
                checkLogin();
                $.ajax({
                    url:"include/detail.php",
                    beforeSend:function(){
                        $("#load-here").html('');
                        $("#load-ajax").show();
                    },
                    data:"id="+id,
                    success:function(load){
                        $("#load-ajax").hide();
                        $("#load-here").html(load);
                        $("#comments").show();
                    }
                });
            });
            $(document).on("pageshow","#detail",function(){
                $(document).on("click","#photo-image", function(){
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
                    $("#dialog-box").hide();
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
                
                $.ajax({
                    url:"include/comment.php",
                    beforeSend:function(){
                        $("#load-more-ajax").show();
                    },
                    data:"id="+id,
                    success:function(comment){
                        $("#content-comment").html(comment);
                        $("#load-more-ajax").hide();
                    }
                });
                
                $("#delete").click(function(){
                    $("#overlay").show();
                    $("#dialog-box").show();
                });
                $("#no").click(function(){
                    $("#overlay").hide();
                    $("#dialog-box").hide();
                });
                
                
                $("#yes").click(function(){
                    $.ajax({
                        url:"include/delete.php",
                        data:"id="+id,
                        success:function(load){
                            if(load == "success"){
                                window.location = 'index.php';
                            }
                        }
                    });
                });
                
                $("button").click(function(){
                    var comment = $("textarea").val();
                    if(comment != ""){
                        $.ajax({
                            url:"include/comment.php",
                            beforeSend:function(){
                                $("#load-more-ajax").show();
                            },
                            data:"id="+id+"&type=com&comment="+comment,
                            success:function(comment){
                                $("textarea").val('');
                                $.ajax({
                                    url:"include/comment.php",
                                    beforeSend:function(){
                                        $("#load-more-ajax").show();
                                    },
                                    data:"id="+id,
                                    success:function(comment){
                                        $("#content-comment").html(comment);
                                        $("#load-more-ajax").hide();
                                    }
                                });
                                $("#load-more-ajax").hide();
                            }
                        });
                    }
                });
                
            });
        </script>
    </body>
</html>