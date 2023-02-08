<?php
namespace Crghome\Shop\Helpers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

class HelperLibs {
    /**
     * test user agent
     * 
     * @return Bool
     */
    public static function isMobile() {
        return (boolean)preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", ($_SERVER["HTTP_USER_AGENT"]??''));
    }

    /**
     * get theme color image
     * 
     * @param String $image
     * @param String $color
     * @param Bool $trumbCheck
     * 
     * @return String
     */
    public static function getTrumbColorImage(String $image, String $color = '#fff', Bool $trumbCheck = true) {
        $imgF = public_path().$image;
        $info = getimagesize($imgF);
        $img = '';
        try{
            $img = match($info[2]){
                1 => imageCreateFromGif($imgF),
                2 => imageCreateFromJpeg($imgF),
                3 => imageCreateFromPng($imgF),
                default => ''
            };
            if(!empty($img)){
                $width = ImageSX($img);
                $height = ImageSY($img);
                
                $thumb = imagecreatetruecolor(1, 1); 
                if($trumbCheck){
                    imagecopyresampled($thumb, $img, 0, 0, 0, 0, 1, 1, $width, $height);
                    $color = '#' . dechex(imagecolorat($thumb, 0, 0));
                } else {
                    $color = '#' . dechex(imagecolorat($img, $width-1, $height-1));
                }
                
                imageDestroy($img);
                imageDestroy($thumb);
            }
        } catch(\Throwable $th){}

        return $color;
    }
}