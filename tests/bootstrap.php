<?php

echo dirname(__DIR__) . '/vendor';
define('PROJECT_VENDOR_DIR', getenv('PROJECT_VENDOR_DIR') ?: dirname(__DIR__) . '/vendor');

require realpath(PROJECT_VENDOR_DIR . '/autoload.php');
