<?php
require_once('testSettings.php');
require_once('Evaluator.php');


function testEval1() {
	assert(3 == Evaluator::evaluate('add(1,2)'));
	assert(9 == Evaluator::evaluate('multiply(add(1,2),add(2,1))'));

	assert(1 == Evaluator::evaluate('abs(1)'));
	assert(1 == Evaluator::evaluate('abs(-1)'));
	assert(9223372036854775807 == Evaluator::evaluate('abs(-9223372036854775807)'));
	assert(9223372036854775807 == Evaluator::evaluate('abs(9223372036854775807)'));
	assert(9223372036854775817 == Evaluator::evaluate('add(9223372036854775807,10)'));

	assert(18446744073709551616 == Evaluator::evaluate('abs(18446744073709551616'));
	assert(18446744073709551616 == Evaluator::evaluate('multiply(18446744073709551616,1)'));

	assert (18837 == Evaluator::evaluate('abs(add(add(add(add(44181,188),32),142),add(subtract(41,25775),28)))'));
}

testEval1();
