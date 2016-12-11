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
                        <div id="chat"></div>
                    </div>
                </div>
                <div id="contents">
                    <h1>HiFood</h1>
                    <p>
                        HiFood adalah sosial media yang berbasis pada resep masakan dan makanan. HiFood membantu setiap orang yang ingin belajar memasak dengan belajar dari resep orang lain yang pernah dibagikan di HiFood. Selain dapat membantu belajar memasak, HiFood membantu setiap orang untuk membagikan resep kreasi mereka sendiri, jadi akan selalu ada resep berbeda dalam suatu masakan, dan resep yang dibagikan merupakan hasil kreasi sendiri sehingga kemungkinan berhasil orang belajar dari setiap resep besar. HiFood juga menyediakan tempat untuk berbagi tentang apa yang kita makan saat ini. Dengan berbagi apa yang kita makan, dapat membantu menjadi pilihan makanan untuk orang lain makan nanti.<br><br>
                        HiFood merupakan aplikasi android buatan mahasiswa Universitas Gunadarma bernama Jepi Usuluddin demi memenuhi tugas Penulisan Ilmiah, dibuat dengan keadaan seadaanya, dibuat pada tahun 2016.
                    </p>
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
            $(document).on('pagebeforeshow', '[data-role="page"]', function(){ 
                $(".menu").html("<div id='mypanel', data-role='panel'></div>");
                $.ajax({
                    url:"include/menu.php",
                    data:"page=about-menu",
                    success: function(data){
                        $("#mypanel").html(data);
                    }
                });

                $.mobile.activePage.find('#mypanel').panel();
                $(document).on('click', '#menu', function(){   
                    $.mobile.activePage.find('#mypanel').panel("open");       
                });
            });
            $(document).on("pagebeforeshow","#index",function(){
                checkBrow();
                checkLogin();
            });
        </script>
    </body>
</html>