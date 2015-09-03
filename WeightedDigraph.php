<?php

require_once('Edge.php');
require_once('PriorityQueue.php');
require_once('iWeightedDiGraph.php');

class WeightedDiGraph implements iWeightedDiGraph{
    public $adjacency;

    public function __construct(){
        $this->adjacency = array();
    }

    public function getNumVertices(){
        return count($this->adjacency);
    }

    public function getVertices(){
        return array_keys($this->adjacency);
    }

    public function getEdgesFor($vertex){
        return $this->adjacency[$vertex];
    }

    public function getAdjacency(){
        return $this->adjacency;
    }

    public function addEdge($startVertex, $endVertex){
        $edge = new Edge($startVertex, $endVertex);
        $this->adjacency[$edge->getFrom()][] = $edge;
    }

    public function addVertex($name) {
        if(!isset($this->adjacency[$name])){
            $this->adjacency[$name] = array();
            return $this->adjacency[$name];
        } else {
            return false;
        }
    }
}