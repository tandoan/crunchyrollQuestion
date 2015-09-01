<?php

require_once('Crawler.php');

class CrawlerFactory{

    public static function createCrawler(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0); //use this to suppress output


        return new Crawler($curl,'http://www.crunchyroll.com/tech-challenge/roaming-math/td@tandoan.com/');
    }
}