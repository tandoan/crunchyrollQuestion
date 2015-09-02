<?php

class PriorityQueue{

    public $data;

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
//        if(isset($this->data[$elem])){
//
//        }
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
//
//$pq = new PriorityQueue();
//$pq->add('1', 0);
//$pq->add('4', 4);
//$pq->add('3', 2);
//$pq->add('5', 1);
//
//print_r($pq->data);
//$v = $pq->extractMin();
//print_r($v);
//print_r($pq->data);
//
//assert('1' == $v);
//
//$pq->extractMin();
//print_r($pq->data);
//
//
//$pq->extractMin();
//print_r($pq->data);
