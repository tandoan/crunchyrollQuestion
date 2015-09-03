<?php

interface iStack
{
    public function size();

    public function push($input);

    public function pop();

    public function peak();

    public function top();
}