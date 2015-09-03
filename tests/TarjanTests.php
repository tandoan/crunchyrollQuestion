<?php
require_once('testSettings.php');
require_once('Tarjan.php');
require_once('WeightedDigraph.php');

function test1(){
    $t = new Tarjan();
    $g = new WeightedDiGraph();

    assert(0 == $t->countCycles($g));
    $g->addVertex('1');
    assert(0 == $t->countCycles($g));

    $g->addEdge('1','1');
    assert(1 == $t->countCycles($g));
}

function test2(){
    $t = new Tarjan();
    $g = new WeightedDiGraph();

    $g->addVertex('1');
    $g->addVertex('2');

    $g->addEdge('1','2');
    $g->addEdge('2','1');
    assert(1 == $t->countCycles($g));
}

function test3(){
    $t = new Tarjan();
    $g = new WeightedDiGraph();

    $g->addVertex('1');
    $g->addVertex('2');
    $g->addVertex('3');

    $g->addEdge('1','2');
    $g->addEdge('2','3');
    $g->addEdge('3','1');
    assert(1 == $t->countCycles($g));
}


function test4(){
    $t = new Tarjan();
    $g = new WeightedDiGraph();

    $g->addVertex('1');
    $g->addVertex('2');
    $g->addVertex('3');
    $g->addVertex('4');
    $g->addVertex('5');
    $g->addVertex('6');
    $g->addVertex('7');
    $g->addVertex('7');

    $g->addEdge('1','2');
    $g->addEdge('2','3');
    $g->addEdge('3','1');
    $g->addEdge('4','2');
    $g->addEdge('4','3');
    $g->addEdge('4','5');
    $g->addEdge('5','4');
    $g->addEdge('5','6');
    $g->addEdge('6','7');
    $g->addEdge('7','6');
    $g->addEdge('8','7');

    assert(3 == $t->countCycles($g));
    $g->addEdge('8','8');
    assert(4 == $t->countCycles($g));


}


test1();
test2();
test3();
test4();