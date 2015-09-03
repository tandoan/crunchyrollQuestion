<?php
require_once('testSettings.php');

require_once('WeightedDigraph.php');
//
//$g = new WeightedDiGraph();
//$g->addVertex('1');
//assert(0 === $g->getDirectedCycleCount());
//$g->addEdge('1','1');
//assert(1 === $g->getDirectedCycleCount());
////
////
//$g = new WeightedDiGraph();
//$g->addVertex('1');
//$g->addVertex('2');
//assert(0 === $g->getDirectedCycleCount());
//$g->addEdge('1','2');
//assert(0 === $g->getDirectedCycleCount());
//$g->addEdge('2','1');
//assert(1 === $g->getDirectedCycleCount());

//
//$g = new WeightedDiGraph();
//$g->addVertex('1');
//$g->addVertex('2');
//$g->addVertex('3');
//assert(0 === $g->getDirectedCycleCount());
//$g->addEdge('1','2');
//$g->addEdge('2','3');
//$g->addEdge('3','1');
//assert(1 === $g->getDirectedCycleCount());
//
//
$g = new WeightedDiGraph();
$g->addVertex('1');
$g->addVertex('2');
$g->addVertex('3');
$g->addVertex('4');
$g->addVertex('5');
$g->addVertex('6');
$g->addEdge('1','2');
$g->addEdge('2','3');
$g->addEdge('2','4');
$g->addEdge('4','1');
$g->addEdge('2','5');
$g->addEdge('5','6');
$g->addEdge('6','2');

//$t = new Tarjan();
//print_r($t->findStronglyConnectComponents($g));
//assert(2 === $g->getDirectedCycleCount());

////
//$g = new WeightedDiGraph();
//$g->addVertex('1');
//$g->addVertex('2');
//$g->addVertex('3');
//$g->addVertex('4');
//$g->addVertex('5');
//$g->addEdge('1','2');
//$g->addEdge('2','3');
//$g->addEdge('3','1');
//$g->addEdge('2','4');
//$g->addEdge('4','5');
//$g->addEdge('5','2');
//$t = new Tarjan();
//print_r($t->findStronglyConnectComponents($g));
//assert(2 === $g->getDirectedCycleCount());

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
$g->addEdge('2','3');
$g->addEdge('3','1');
$g->addEdge('4','2');
$g->addEdge('4','3');
$g->addEdge('4','5');
$g->addEdge('5','4');
$g->addEdge('5','6');
$g->addEdge('6','3');
$g->addEdge('6','7');
$g->addEdge('7','6');
$g->addEdge('8','5');
$g->addEdge('8','7');
//$g->addEdge('8','8');
$t = new Tarjan();
$cycles = $t->countCycles($g);
echo "Cycles = $cycles\n";
//print_r($t->findStronglyConnectComponents($g));