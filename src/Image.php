<?php

namespace Niyko\NoiseCaptcha;

class Image
{
    public static function create(string $code){
        $width = 150;
        $height = 50;
        $image = imagecreatetruecolor($width, $height);

        $bg_color = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 0, 0, 0);

        $font_size = 10;
        $x = 15;
        $y = 15;

        imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);
        imagestring($image, $font_size, $x, $y, $code, $text_color);

        for($i=0; $i<10; $i++){
            $random_color = self::getRandomRGBColor();
            $line_color = imagecolorallocate($image, $random_color[0], $random_color[1], $random_color[2]);
            imageline($image, rand(0,$width), rand(0,$height), rand(0,$width), rand(0,$height), $line_color);
        }

        ob_start();
        imagepng($image);

        $image_data = ob_get_clean();

        imagedestroy($image);

        $base64 = base64_encode($image_data);
        $base64 = 'data:image/png;base64,'.$base64;

        return $base64;
    }

    private static function getRandomRGBColor(){
        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);

        return [$r, $g, $b];
    }
}