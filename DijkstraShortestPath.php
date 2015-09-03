<?php

class DijkstraShortestPath
{

    public function getShortestPath(WeightedDiGraph $graph, $start,$end){

        $ret = $this->calculateDistanceAndPredecessor($graph,$start);
        $predecessors = $ret['predecessors'];

        $path = array();
        $path[] = $end;
        while($path[count($path)-1] != $start){
            $path[] = $predecessors[$path[count($path)-1]]->getFrom();
        }
        $path = array_reverse($path);
        return $path;
    }

    /**
     * Implementation of Dijkstra's shortest path algorithm
     * @param $graph
     * @param $start
     * @return array
     */
    public function calculateDistanceAndPredecessor(WeightedDiGraph $graph, $start){
        $distance = array();
        $marked = array();
        $predecessors = array(); // array of edges to a vertex
        $pq = new PriorityQueue();

        foreach($graph->getVertices() as $vertex){
            $distance[$vertex] = PHP_INT_MAX;
            $predecessors[$vertex] = null;
            $marked[$vertex] = false;
        }

        $distance[$start] = 0.0;
        $pq->add($start, 0.0);

        while(!$pq->isEmpty()){
            $v = $pq->extractMin();
            if($marked[$v]) continue;
            $marked[$v] = true;

            $edges = $graph->getEdgesFor($v);

            foreach($edges as $edge){
                $w = $edge->getTo();
                $alt = $distance[$v] + $edge->getWeight();
                if($alt < $distance[$w] ){
                    $distance[$w] = $alt;
                    $predecessors[$w] = $edge;
                    $pq->add($w, $alt);
                }
            }
        }
        return array( 'distance' => $distance, 'predecessors'=> $predecessors);

    }
}