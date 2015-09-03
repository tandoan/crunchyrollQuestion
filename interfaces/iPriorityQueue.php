<?php

interface iPriorityQueue
{

    public function isEmpty();

    public function add($elem, $weight);

    public function decreasePriority($elem, $weight);

    public function extractMin();
}
