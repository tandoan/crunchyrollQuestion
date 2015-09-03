<?php
$includePath = get_include_path();
$cwd = getcwd();
set_include_path($includePath . PATH_SEPARATOR . $cwd.'/../' . PATH_SEPARATOR . $cwd.'/../interfaces');
