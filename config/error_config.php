<?php

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/errors.log');
error_reporting(E_ALL);


set_error_handler(function($errno, $errstr, $errfile, $errline){
    error_log("Error [$errno]: $errstr in $errfile on line $errline");
});