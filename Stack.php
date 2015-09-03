<?php

require_once('iStack.php');
class Stack implements iStack{
	private $data;

	public function __construct(){
		$this->data = array();
	}

	public function size(){
		return count($this->data);
	}

	public function push($input){
		array_push($this->data,$input);
	}

	public function pop(){
		return array_pop($this->data);
	}

	public function peak(){
		$top = array_pop($this->data);
		$next = array_pop($this->data);
		array_push($this->data,$next);
		array_push($this->data,$top);
		return $next;
	}

	public function top(){
		$top = array_pop($this->data);
		array_push($this->data,$top);
		return $top;
	}

}
