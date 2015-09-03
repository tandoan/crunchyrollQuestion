<?php
require_once('Stack.php');

/**
 * Class Tarjan
 * implemented from https://en.wikipedia.org/wiki/Tarjan%27s_strongly_connected_components_algorithm
 */
class Tarjan {

    public $index;
    public $stack;
    public $vertexIndexes;
    public $vertexLowLink;
    public $vertexOnStack;
    public $stronglyConnectedComponents;
    public $digraph;


    public function countCycles(WeightedDiGraph $digraph){
        $stronglyConnectedComponents = $this->findStronglyConnectComponents($digraph);
        $count = 0;
        foreach($stronglyConnectedComponents as $scc) {
            if(count($scc) > 1){
                $count++;
            } else {
                $v = $scc[0];
                $edges = $digraph->getEdgesFor($v);
                foreach($edges as $edge) {
                    if($edge->getTo() == $v){
                        $count++;
                        break;
                    }
                }
            }

        }
        return $count;

    }

    public function findStronglyConnectComponents(WeightedDiGraph $digraph) {
        $this->stronglyConnectedComponents = array();
        $this->digraph = $digraph;
        $this->index = 0;
        $this->stack = new Stack();
        $this->vertexIndexes = array();
        $this->vertexLowLink = array();
        $this->vertexOnStack = array();

        $vertices = $digraph->getVertices();
        foreach($vertices as $vertex) {
            if (!$this->vertexIndexes[$vertex]) {
                $this->strongConnect($vertex);
            }
        }

        return $this->stronglyConnectedComponents;
    }

    public function strongConnect($v){
        $this->vertexIndexes[$v] = $this->index;
        $this->vertexLowLink[$v] = $this->index;
        $this->index++;

        $this->stack->push($v);
        $this->vertexOnStack[$v] = true;

        $edges = $this->digraph->getEdgesFor($v);
        foreach($edges as $edge){
            $w = $edge->getTo();
            if(!$this->vertexIndexes[$w]){
                $this->strongConnect($w);
                $this->vertexLowLink[$v] = min($this->vertexLowLink[$v], $this->vertexLowLink[$w]);
            } elseif($this->vertexOnStack[$w]){
                $this->vertexLowLink[$v] = min ($this->vertexLowLink[$v], $this->vertexIndexes[$w]);
            }
        }

        // If v is a root node, pop the stack and generate an SCC
        if($this->vertexLowLink[$v] == $this->vertexIndexes[$v]){
            $scc = array();
            do {
                $w = $this->stack->pop();
                $this->vertexOnStack[$w] = false;
                $scc[] = $w;
            } while($w != $v);

            $this->stronglyConnectedComponents[] = $scc;
        }
    }
}