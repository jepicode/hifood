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
                        <div id="menu" style="background-image:none !important"></div>
                    </div>
                    <div id="center">
                        <div id="logo"></div>
                    </div>
                    <div id="right">
                        <div id="chat" style="background-image:none !important"></div>
                    </div>
                </div>
                <div id="contents">
                    <h1>Peringatan!</h1>
                    <p>
                        HiFood merupakan sebuah aplikasi <b>Android</b> berbasis Web. Aplikasi ini membuka website melalui aplikasi, walau begitu website tetap bisa dibuka diluar aplikasi tersebut dengan menggunakan browser. Anda dapat tetap membuka website ini di browser dengan mengabaikan semua resiko yang ada.<br><br>
                    </p>
                    <div id="download">
                        <a href="hifood.apk" data-role="none" data-ajax="false"><button data-role="none">Unduh</button></a>
                        <b>atau</b>
                    </div>
                    <button data-role="none" id="visit">Kunjungi Website HiFood</button>
                </div>
                
            </div>
                    
        </div>

        <style>
            .ui-overlay-a,
            .ui-page-theme-a,
            .ui-page-theme-a .ui-panel-wrapper {
                background-color: #FFF !important;
            }
            #contents {
                margin-top:20px; padding: 20px; width:80%; margin:20px auto 0 auto; text-align: center; box-sizing: border-box;
            }
            p {
                text-align: justify;
            }
            button {
                width:100%; padding: 10px; box-sizing: border-box; background: #ff9800; border:0; color: #fff; font-weight: bold; outline: none; cursor: pointer; border-radius:5px; -webkit-border-radius:5px;
            }
            button:active {
                background:#985d00;
            }
            #download {
                display:none;
            }
            #atau {
                margin:20px auto;
            }
        </style>
        
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.mobile.min.js"></script>
        <script src="js/check-login.js"></script>
        <script src="js/check-chat.js"></script>
        <script src="js/check-browser.js"></script>
        <script>
            $(document).on("pagebeforeshow","#index",function(){
                checkBrowser();
            });
            $(document).on("pageshow","#index",function(){
                var getBrowsers = getMobileOperatingSystem();
                if(getBrowsers == "Android"){
                    $("p").append("Untuk anda pengguna <b>Android</b>, anda dapat mengunduh aplikasi HiFood.");
                    $("#download").show();
                    $("#visit").html("Tetap Kunjungi Versi Web");
                }
                $("#visit").click(function(){
                   $.ajax({
                       url:"include/check-browser.php",
                       data:"update=true",
                       success:function(update){
                            window.location='index.php';
                       }
                    }); 
                });
            });
            var getMobileOperatingSystem = function() {
              var userAgent = navigator.userAgent || navigator.vendor || window.opera;
                if (/windows phone/i.test(userAgent)) {
                    return "Windows Phone";
                }
                if (/android/i.test(userAgent)) {
                    return "Android";
                }
                if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                    return "iOS";
                }
                return "unknown";
            }
        </script>
    </body>
</html>