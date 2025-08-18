<?php

namespace Niyko\NoiseCaptcha;

class NoiseCaptcha
{
    private string $base64_image;
    private string $code;
    private string $token;

    private function __construct(string $secret){
        $this->code = self::getRandomCode();
        $this->token = self::createToken($secret, $this->code);
        $this->base64_image = Image::create($this->code);
    }

    public static function generate(string $secret){
        return new self($secret);
    }

    public static function check(string $secret, string $code, string $token){
        return $token==self::createToken($secret, $code);
    }

    private function getRandomCode(){
        $code ='';
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

        for($i=0; $i<8; $i++){
            $code .= $chars[rand(0, strlen($chars)-1)];
        }

        return $code;
    }

    public function getBase64Image(){
        return $this->base64_image;
    }

    public function getToken(){
        return $this->token;
    }

    private static function createToken(string $secret, string $code){
        $token = $code.'-'.$secret.'-'.self::getTimestamp();
        $token = hash('sha256', $token);

        return $token;
    }

    private static function getTimestamp(){
        $interval = 600;
        $now = time();
        $rounded_timestamp = floor($now/$interval)*$interval;

        return $rounded_timestamp;
    }
}