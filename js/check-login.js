var checkLogin = function(){
    $.ajax ({
        url:"include/check-login.php",
        success:function(login){
            if(login == "yes")
                window.location = "index.php";  
        }
    });
}