<?php
require_once('testSettings.php');
require_once('PriorityQueue.php');

$pq = new PriorityQueue();
$pq->add('1', 0);
$pq->add('4', 4);
$pq->add('3', 2);
$pq->add('5', 1);

$v = $pq->extractMin();
assert('1' == $v);

$v = $pq->extractMin();
assert('5' == $v);

$v = $pq->extractMin();
assert('3' == $v);
