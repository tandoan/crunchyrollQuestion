<?php
require_once('Stack.php');

/**
 * Class Evaluator
 * Evaluate the expressions per spec.
 * Prefix notation, 4 operators: add, multiply, subtract, abs
 * No error handling due to guarantee of correctness
 */
class Evaluator {

    const OPEN_PAREN = '(';
    const CLOSE_PAREN = ')';
    const COMMA = ',';
    const ADD = 'add';
    const MULTIPLY = 'multiply';
    const SUBTRACT = 'subtract';
    const ABS = 'abs';

    private static function isPunctuation($c){
        return ($c == self::OPEN_PAREN || $c == self::CLOSE_PAREN|| $c == self::COMMA);
    }

    /**
     * Attempt to do 1 level of evaluation
     * @param Stack $stack
     * @return mixed
     */
    private static function doEval($stack){
        //naive way to handle
        $rhs = $stack->pop();
        $lhs = $stack->pop();
        if($lhs === self::ABS){
            $stack->push(abs($rhs));
        } elseif(is_numeric($lhs) && is_numeric($rhs)) {
            $maybeOperator = $stack->pop();
            switch($maybeOperator){
                case self::ADD:
                    $stack->push(bcadd($lhs, $rhs));
                    break;

                case self::SUBTRACT:
                    $stack->push(bcsub($lhs, $rhs));
                    break;
                case self::MULTIPLY:
                    $stack->push(bcmul($lhs, $rhs));
                    break;
                default:
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

    /**
     * @param String $input
     * @return mixed
     */
    public static function evaluate($input){
        $stack = new Stack();
        $length = strlen($input);
        $i = 0;
        while($i < $length){
            $currentValue = null;

            if(!self::isPunctuation($input[$i]) ){
                $boundaries = array();
                $comma  = strpos($input, self::COMMA, $i);
                $closeParen = strpos($input, self::CLOSE_PAREN, $i);
                $openParen = strpos($input, self::OPEN_PAREN, $i);
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

                $boundary = min($boundaries);

                $token = substr($input, $i, $boundary-$i);
                $i = $boundary+1;

                // push number and process
                if( is_numeric($token)){
                    $stack->push($token);
                    $stack = self::doEval($stack);

                } else {
                    // else just push operator
                    $stack->push($token);
                }
            } else {
                if($input[$i] === self::CLOSE_PAREN){
                    $stack = self::doEval($stack);
                }
                $i++;

            }
        }

        return $stack->pop();
    }

}