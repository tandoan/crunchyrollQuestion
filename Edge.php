<?php

class Edge {

    public $from;
    public $to;
    public $weight;

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

