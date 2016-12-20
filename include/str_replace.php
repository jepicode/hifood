<?php
function replace($str) {
    $str = str_replace(PHP_EOL,"<br>",$str);
    $str = str_replace("'","&#39;",$str);
    $str = str_replace('"','&quot',$str);
    $str = str_replace(",","&#44;",$str);
    return $str;
}
function back($str){
    $str = str_replace("<br>","\n",$str);
    $str = str_replace("&#39;","'",$str);
    $str = str_replace('&quot;','"&quot"',$str);
    $str = str_replace("&#44;",",",$str);
    return $str;
}
?>