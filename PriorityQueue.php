<?php

require_once('iPriorityQueue.php');

class PriorityQueue implements iPriorityQueue{

    private $data;

    public function __construct(){
        $this->data = array();
    }

    public function isEmpty(){
        if(0 === count($this->data)){
            return true;
        }
        return false;
    }

    public function add($elem,$weight){

        $this->data[$elem] = $weight;
    }

    public function decreasePriority($elem, $weight){
        $this->data[$elem] = $weight;
    }

    public function extractMin(){
        arsort($this->data);
        $keys = array_keys($this->data);
        $key = array_pop($keys);
         array_pop($this->data);

        return $key;

    }
}