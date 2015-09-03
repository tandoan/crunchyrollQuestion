<?php

require_once('iPriorityQueue.php');

class PriorityQueue implements iPriorityQueue{

    private $data;

    public function __construct(){
        $this->data = array();
    }

    public function isEmpty(){
        return (0 === count($this->data));
    }

    public function add($elem,$weight){
        if(!isset($this->data[$elem])) {
            $this->data[$elem] = $weight;
        } else {
            throw new InvalidArgumentException('Element already exists in queue: ', $elem);
        }
    }

    public function decreasePriority($elem, $weight){
        if(isset($this->data[$elem])){
            $this->data[$elem] = $weight;
        } else {
            throw new InvalidArgumentException('Element is not in queue: ', $elem);
        }
    }

    public function isElementInQueue($elem){
        return isset($this->data[$elem]);
    }

    public function extractMin(){
        arsort($this->data);
        $keys = array_keys($this->data);
        $key = array_pop($keys);
        array_pop($this->data);

        return $key;

    }
}