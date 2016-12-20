<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HiFood</title>

        <link rel="stylesheet" href="css/jquery.mobile.min.css">
        <link rel="stylesheet" href="css/splash.css">

    </head>
    <body>
        
        <div data-role="page" id="splash">
        
            <div class="ui-content">
                
            </div>
        
        </div>
        
        <a href="index.php" data-transition="slideup" id="to-index"></a>

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mobile.min.js"></script>
        <script>
            $(document).on("pagebeforeshow","#splash",function(){
                $(".ui-content").html('<img src="img/logo-splash.png" id="logo-splash"><img src="img/loading-splash.gif" id="loading-splash">');
            });
            $(document).on("pageshow","#splash",function(){
                setTimeout(function(){
                    $.ajax({
                       url:"include/splashscreen.php",
                        data:"success=true",
                        success:function(splash){
                            if(splash == "yes-success") 
                                window.location='login.php';
                        }
                    });
                }, 3000);
                $.ajax({
                    url:"include/splashscreen.php",
                    success:function(splash){
                        if(splash == "no") 
                            window.location='login.php';
                    }
                });
            });
        </script>
    </body>
</html>