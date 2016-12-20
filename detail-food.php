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
            
            <div class="ui-content">
                <div id="header">
                    <div id="left">
                        <div id="back" onclick="window.location='food.php'"></div>
                    </div>
                    <div id="center">
                        <div id="logo"></div>
                    </div>
                    <div id="right">
                        <div id="delete"></div>
                    </div>
                </div>
                <div id="load-here" style="margin-top:50px;">
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
                <center>
                    <img src="img/load-ajax.gif" id="load-more-ajax">
                </center>
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
        <script src="js/check-login.js"></script>
        <script src="js/url-parameter.js"></script>
        <script>
            var id = getUrlParameter('id');
            var type = "new";
            $(document).on("pagebeforeshow","#index",function(){
                checkLogin();
                tabs();
            });
            $(document).on("pageshow","#index",function(){
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
                $("#overlay").click(function(){
                    $("#overlay").hide();
                    $("#img-here").hide();
                    $("#dialog-box").hide();
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
                                window.location = 'food.php';
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
            var tabs = function(){
                $.ajax({
                    url:"include/detail-food.php",
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
            }
        </script>
    </body>
</html>