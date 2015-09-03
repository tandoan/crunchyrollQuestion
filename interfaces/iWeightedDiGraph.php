<?php

interface iWeightedDiGraph {


    public function getNumVertices();

    public function getVertices();

    public function getEdgesFor($vertex);

    public function addEdge($startVertex, $endVertex);

    public function addVertex($name);
}