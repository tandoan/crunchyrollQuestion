<?php
require_once('MyStack.php');

class Evaluator {

	public static function isPunctuation($c){
		return ($c == '(' || $c == ')' || $c == ',');
	}

	/**
	 * Attempt to do 1 level of evaluation
	 * @param $stack
	 * @return mixed
	 */
	public static function doEval($stack){
		//naieve way to handle
		$rhs = $stack->pop();
		$lhs = $stack->pop();
		if($lhs === 'abs'){
			echo "ABSNG!  $rhs\n";
			$stack->push(abs($rhs));
		} elseif(is_numeric($lhs) && is_numeric($rhs)) {
			$maybeOperator = $stack->pop();
			switch($maybeOperator){
				case 'add':
					echo "adding $lhs $rhs \n";
					$stack->push($lhs + $rhs);
				break;

				case 'subtract':
					echo "subbing $lhs $rhs \n";
					$stack->push($lhs - $rhs);
				break;
				case 'multiply':
					echo "mult $lhs $rhs \n";
					$stack->push($lhs * $rhs);
				break;
				default:
					echo "put it back  $maybeOperator, $lhs, $rhs \n";
					$stack->push($maybeOperator);
					$stack->push($lhs);
					$stack->push($rhs);
				break;
			}
		} else {
			$stack->push($lhs);
			$stack->push($rhs);
		}
		return $stack;
	}
	public static function evaluate($input){
		$stack = new MyStack();
		$length = strlen($input);
		$i = 0;
		$count = 0;
		while($i < $length){
			$lastOperator = '';
			$currentValue = null;

			if(!self::isPunctuation($input[$i]) ){
				// echo "char ".$input[$i]."\n";
				$boundaries = array();
				$comma  = strpos($input, ',', $i);
				$closeParen = strpos($input, ')', $i);
				$openParen = strpos($input, '(', $i);
				if(false !== $comma){
					$boundaries[] = $comma;
				}
				if(false !== $closeParen){
					$boundaries[] = $closeParen;
				}
				if(false !== $openParen){
					$boundaries[] = $openParen;
				}
				$boundaries[] = $length;

				$boundry = min($boundaries);
				// echo "brounry is $boundry \n";

				$token = substr($input, $i, $boundry-$i);
				$i = $boundry+1;

				// push number and process
				// if($input[$i] == '-' || is_numeric($input[$i])){
				if( is_numeric($token)){
					echo "pushing number $token \n";

					$stack->push($token);

					$stack = self::doEval($stack);

				} else {
					// else just push operator
					echo "pushing $token \n";
					$stack->push($token);
					$lastOperator = $token;
					
				}
			} else {
				$i++;
			}
		}

		// since we discarded all the ), we need to go through and get the stack to 1 element
		while($stack->size() > 1){
			$stack = self::doEval($stack);
		}

		return $stack->pop();
	}

}

function testEval1() {
	$input = '1,2,-34';
	// assert(array(1,2,-34) == Evaluator::evaluate('1,2,-34'));
	// assert(array(1,2,34) == Evaluator::evaluate('1,2,34'));
	print_r(Evaluator::evaluate('abs(add(add(add(add(44181,188),32),142),add(subtract(41,25775),28)))'));
}

// function givenTest(){

// 	$input = 'abs(add(add(add(add(44181,188),32),142),add(subtract(41,25775),28)))';
// 	$expected = '18837';
// 	$actual = Evaluator::evaluate($input);
// 	if($expected != $actual){
// 		throw new Exception('sad panda');
// 	}
// }

//givenTest();
testEval1();
