<?php
require_once('iEdge.php');

class Edge implements iEdge{

    private $from;
    private $to;
    private $weight;

    public function __construct($from, $to, $weight = 1){
        $this->from = $from;
        $this->to = $to;
        $this->weight = $weight;
    }

    public function getFrom(){
        return $this->from;
    }

    public function getTo(){
        return $this->to;
    }

    public function getWeight(){
        return $this->weight;
    }
}

