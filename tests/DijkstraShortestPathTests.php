<?php
require_once('testSettings.php');
require_once('WeightedDigraph.php');
require_once('DijkstraShortestPath.php');

function testDistance1(){

    $g = new WeightedDiGraph();
    $g->addVertex('1');
    $g->addVertex('2');
    $g->addVertex('3');
    $g->addVertex('4');
    $g->addVertex('5');
    $g->addVertex('6');

    $g->addEdge('1','2');
    $g->addEdge('1','4');
    $g->addEdge('2','3');
    $g->addEdge('2','6');
    $g->addEdge('4','5');

    $d = new DijkstraShortestPath();
    $return = $d->calculateDistanceAndPredecessor($g,'1');
    assert( array(1=>0, 2=>1, 3=>2, 4=>1, 5=>2, 6=>2) == $return['distance']);
}

function testDistance2(){

    $g = new WeightedDiGraph();
    $g->addVertex('1');
    $g->addVertex('2');
    $g->addVertex('3');
    $g->addVertex('4');

    $g->addEdge('1','2');
    $g->addEdge('1','4');
    $g->addEdge('2','3');
    $g->addEdge('3','4');

    $d = new DijkstraShortestPath();
    $return = $d->calculateDistanceAndPredecessor($g,'1');
    assert( array(1=>0, 2=>1, 3=>2, 4=>1) == $return['distance']);
}

function testPath1(){

    $g = new WeightedDiGraph();
    $g->addVertex('1');
    $g->addVertex('2');
    $g->addVertex('3');
    $g->addVertex('4');
    $g->addVertex('5');
    $g->addVertex('6');

    $g->addEdge('1','2');
    $g->addEdge('1','4');
    $g->addEdge('2','3');
    $g->addEdge('2','6');
    $g->addEdge('4','5');

    $d = new DijkstraShortestPath();
    assert(array('1','2','6') == $d->getShortestPath($g,'1','6'));
    assert(array('1','2','3') == $d->getShortestPath($g,'1','3'));
}

function testPath2(){
    $g = new WeightedDiGraph();
    $g->addVertex('1');
    $g->addVertex('2');
    $g->addVertex('3');
    $g->addVertex('4');
    $g->addVertex('5');
    $g->addVertex('6');
    $g->addVertex('7');
    $g->addVertex('8');

    $g->addEdge('1','2');
    $g->addEdge('1','4');
    $g->addEdge('1','5');
    $g->addEdge('2','3');
    $g->addEdge('3','7');
    $g->addEdge('5','6');
    $g->addEdge('6','8');
    $g->addEdge('7','8');

    $d = new DijkstraShortestPath();
    assert( array() == $d->getShortestPath($g,'4','8'));
    assert( array('1','5','6','8') == $d->getShortestPath($g, '1','8'));

}
testDistance1();
testDistance2();
testPath1();
testPath2();