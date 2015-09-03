<?php
require_once('testSettings.php');

require_once('MyStack.php');

$myStack = new Stack();
assert(0 == $myStack->size());

$myStack->push(1);
assert(1 == $myStack->size());

$myStack->push(2);
assert(2 == $myStack->size());


$p =  $myStack->pop();
assert(1 == $myStack->size());
assert($p == 2);

$myStack->push(3);
assert(2 == $myStack->size());

$t =  $myStack->top();
assert(3 == $t);
$p = $myStack->peak();
assert(1 == $p);
