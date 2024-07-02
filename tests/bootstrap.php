<?php

define('PROJECT_VENDOR_DIR', getenv('PROJECT_VENDOR_DIR') ?: dirname(__DIR__, 4) . '/vendor');

require realpath(PROJECT_VENDOR_DIR . '/autoload.php');
