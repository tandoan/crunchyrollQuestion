<?php

class HTTP
{

    private $curl;
    private $baseURL;

    public function __construct($curl, $baseURL)
    {
        $this->curl = $curl;
        $this->baseURL = $baseURL;
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }

    public function get($url)
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        $result = curl_exec($this->curl);
        return $result;
    }

    public function getFrom($integer)
    {
        return $this->get($this->baseURL . $integer);
    }
}