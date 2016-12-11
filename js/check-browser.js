var isNativeApp = function() {
    return /HiFood\/[0-9\.]+$/.test(navigator.userAgent);
}
var brow = isNativeApp();
var checkBrow = function(){
    if(brow == false){
        $.ajax({
            url:"include/check-browser.php",
            data:"check=true",
            success:function(brow) {
                if(brow == "false"){
                    window.location='check-browser.php';
                }
            }
        });
    }
};
var checkBrowser = function(){
    if(brow == false){
        $.ajax({
            url:"include/check-browser.php",
            data:"check=true",
            success:function(brow) {
                if(brow == "false"){
                    
                }
                else
                    window.location='index.php';
            }
        });
    }
};