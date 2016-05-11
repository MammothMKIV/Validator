<?php

spl_autoload_register(function ($class) {
    $filename = dirname(__FILE__) . '/src/' . $class . '.php';

    if (file_exists($filename)) {
        require $filename;
    }
});
