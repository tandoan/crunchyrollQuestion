<?php

require_once('Edge.php');
require_once('PriorityQueue.php');

class WeightedDiGraph {
    public $adjacency;

    public $cycleCount = 0;
    public $cycleVisted = array();

    public function __construct(){
        $this->adjacency = array();
    }

    public function getNumVertices(){
        return count($this->adjacency);
    }

    public function getVertices(){
        return $this->adjacency;
    }

    public function getEdgesFor($vertex){
        return $this->adjacency[$vertex];
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

////    public function getDirectedCycleCount(){
////        $visited = array();
////        $stack = array();
////        $count = 0;
////
////        foreach($this->adjacency as $vertex=>$edges) {
////            $visited[$vertex] = false;
////            $stack[$vertex] = false;
////        }
////
////        foreach($this->adjacency as $vertex=>$edges) {
////            if($this->isCyclic($vertex, $visited, $stack)){
////                $count++;
////            }
////        }
////        echo "FINAL COUNT $count\n";
////        return $count;
////    }
//
////    private function isCyclic($vertex, $visited, $stack){
////        if(!$visited[$vertex]){
////            $visited[$vertex] = true;
////            $stack[$vertex] = true;
////
////            foreach($this->adjacency[$vertex] as $edge){
////                if(!$visited[$edge->getTo()] && $this->isCyclic($edge->getTo(), $visited, $stack)){
////                    return true;
////                } elseif($stack[$edge->getTo()]){
////                    return true;
////                }
////            }
////        }
////        $stack[$vertex] = false;
////        return false;
////    }
//
//    public function getDirectedCycleCount(){
//        $this->cycleCount = 0;
//        $this->cycleVisted = array();
//        foreach($this->adjacency as $vertex=>$edges) {
//            $this->cycleVisted[$vertex] = false;
//        }
//        foreach($this->adjacency as $vertex=>$edges) {
////            $this->depthFirstSearch($vertex, array());
////            echo "outer loop: $vertex\n";
//            $this->depthFirstSearch($vertex, array(), array());
//            $this->cycleVisted[$vertex] = true;
//
//        }
//
//        echo "FINAL COUNT: {$this->cycleCount}\n";
//        return $this->cycleCount;
//    }
//
//    private function depthFirstSearch($v, $visited, $stack) {
////        echo "dfs  $v  \n;";
//        if (!$visited[$v]) {
//
//            $visited[$v] = true;
//            foreach ($this->adjacency[$v] as $edge) {
//                $next = $edge->getTo();
//                $this->depthFirstSearch($next, $visited, $stack);
//            }
//
//        } else {
////            echo "visted!  chck cycle visite\n";
////            print_r($this->cycleVisted);
////            print_r($visited);
//            if(!$this->cycleVisted[$v]){
//                $this->cycleCount++;
//                foreach($visited as $visitedNode => $value){
//                    if($value){
//                        $this->cycleVisted[$visitedNode] = true;
//                    }
//                }
//
////                echo "new cycle visited\n";
////                print_r($this->cycleVisted);
////                echo "count is  {$this->cycleCount}\n";
//            }
//
//        }
//    }

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