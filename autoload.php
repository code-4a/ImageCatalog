<?php

function __autoload($class)
{
    $paths = ['/libraries/', '/controllers/', '/models/'];
    foreach ($paths as $subdir) {
        $fullpath = __DIR__ . $subdir . $class . '.php';
        if(file_exists($fullpath)) {
            require $fullpath;
        }
    }
}
