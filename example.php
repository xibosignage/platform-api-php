<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2016 Spring Signage Ltd
 * (example.php)
 */
include 'vendor/autoload.php';

$provider = new \Xibo\Platform\Provider\XiboPlatform([
    'clientId' => 't3POgoBphkVfuA6PbfSzUTnPjZC2cj3hhanOUuMn',
    'clientSecret' => '878b84dc5b5c7bd36567bd1bbfa8395dc82863e8566eae30a9ddeeaa60f44623',
    'mode' => 'TEST'
]);

try {
    var_export($provider->me());
} catch (Exception $e) {
    echo 'Exception: ' . PHP_EOL;
    echo $e->getMessage()  . PHP_EOL;
    echo $e->getTraceAsString();
}