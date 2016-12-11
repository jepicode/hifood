<?php 
function setTransparency($new_image,$image_source) {
    $transparencyIndex = imagecolortransparent($image_source); 
    $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255); 
    if ($transparencyIndex >= 0) { 
        $transparencyColor    = imagecolorsforindex($image_source, $transparencyIndex);    
    } 
    $transparencyIndex    = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']); 
    imagefill($new_image, 0, 0, $transparencyIndex); 
     imagecolortransparent($new_image, $transparencyIndex); 
} 
?>

<?php
function imageResize($target, $newcopy, $w, $h, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $scale_ratio = $w_orig / $h_orig;
    if($w_orig < $w && $h_orig < $h) {
        $w = $w_orig;
        $h = $h_orig;
    }
    else if (($w / $h) > $scale_ratio) {
           $w = $h * $scale_ratio;
    } 
    else {
           $h = $w / $scale_ratio;
    }
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){ 
      $img = imagecreatefromgif($target);
    } 
    else if($ext =="png"){ 
      $img = imagecreatefrompng($target);
    } 
    else { 
      $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    setTransparency($tci,$img); 
    // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy, 80);
}
?>