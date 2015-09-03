<?php

require_once('HTTP.php');

class HTTPFactory
{

    public static function create($baseURL = 'http://www.crunchyroll.com/tech-challenge/roaming-math/td@tandoan.com/')
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0); //suppress output


        return new HTTP($curl, $baseURL);
    }
}