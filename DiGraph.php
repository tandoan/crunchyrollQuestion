<?php

class DiGraph {
    public $rows = array();
    public $edgeCount = 0;

    public function getNumVertices(){
        return count($this->rows);
    }

    public function getShortestPath($start,$end){
        return array("a","b","c");
    }

    public function getDirectedCycleCount(){
        return 1;
    }

    public function addVertex($name){
        if(!isset($this->rows[$name])){
            $this->rows[$name] = array();
            return $this->rows[$name];
        } else {
            return false;
        }
    }

    public function addEdge($startVertex,$endVertex){
        $edgeIndex = $this->edgeCount+1;
        $this->rows[$startVertex][$edgeIndex] = -1;
        $this->rows[$endVertex][$edgeIndex] = 1;
        $this->edgeCount = $edgeIndex;
    }

}
//
//$g = new DiGraph();
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
//
//
//print_r($g->rows);