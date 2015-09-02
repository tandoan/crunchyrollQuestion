<?php

require_once('Edge.php');
require_once('PriorityQueue.php');

class WeightedDiGraph {
    public $adjacency;

    public function __construct(){
        $this->adjacency = array();
    }

    public function getNumVertices(){
        return count($this->adjacency);
    }

    /**
     * Implementation of Dijkstra's shortest path algorithm
     * @param $start
     * @param $end
     * @return array
     */
    public function getShortestPath($start,$end){
        $distance = array();
        $marked = array();
        $prev = array(); // array of edges to a vertex
        $pq = new PriorityQueue();

        foreach($this->adjacency as $k=>$v){
            $distance[$k] = PHP_INT_MAX;
            $prev[$k] = null;
            $marked[$k] = false;
        }

        $distance[$start] = 0.0;
        $pq->add($start, 0.0);

        while(!$pq->isEmpty()){
            $v = $pq->extractMin();
            if($marked[$v]) continue;
            $marked[$v] = true;

            $edges = $this->adjacency[$v];

            foreach($edges as $edge){
                $w = $edge->getTo();
                $alt = $distance[$v] + $edge->getWeight();
                if($alt < $distance[$w] ){
                    $distance[$w] = $alt;
                    $prev[$w] = $edge;
                    $pq->add($w, $alt);
                }
            }
        }

        $path = array();
        $path[] = $end;
        while($path[count($path)-1] != $start){
            $path[] = $prev[$path[count($path)-1]]->getFrom();
        }
        $path = array_reverse($path);
        return $path;
    }

    public function getDirectedCycleCount(){
        return 1;
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
//
//$g = new WeightedDiGraph();
//$g->addVertex('1');
//$g->addVertex('2');
//$g->addVertex('3');
//$g->addVertex('4');
//
//$g->addEdge('1','2');
//$g->addEdge('2','3');
//$g->addEdge('3','4');
//$g->addEdge('2','4');
//$g->addEdge('4','1');
//$g->addEdge('4','2');
//
//
//print_r($g->adjacency);