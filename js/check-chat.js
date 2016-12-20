var check = function(){
    setInterval(function(){
        $.ajax({
            url:"include/check-new-chat.php",
            data:"for=check",
            success:function(check){
                if(parseInt(check) > 0){
                    $("#chat").css("background-image","url(img/chat-active.png)");
                }
            }
        });
    },3000);
}