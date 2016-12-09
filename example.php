<?php
/*
 * Spring Signage Ltd - http://www.springsignage.com
 * Copyright (C) 2016 Spring Signage Ltd
 * (example.php)
 */
include 'vendor/autoload.php';

// Monolog (requires dev composer dependencies)
$handlers = [
    new Monolog\Handler\StreamHandler(STDOUT)
];
$processors = [
    new Monolog\Processor\UidProcessor()
];

$log = new Monolog\Logger('PLATFORM-API', $handlers, $processors);

$provider = new \Xibo\Platform\Provider\XiboPlatform([
    'clientId' => 't3POgoBphkVfuA6PbfSzUTnPjZC2cj3hhanOUuMn',
    'clientSecret' => '878b84dc5b5c7bd36567bd1bbfa8395dc82863e8566eae30a9ddeeaa60f44623',
    'mode' => 'TEST'
], [
    'logger' => $log
]);

try {

   /* // Create a simple android product and get a quote
    $android = new \Xibo\Platform\Entity\Product\Android();
    $android->emailAddress = 'a+' . rand() . '@springsignage.com';
    $android->version = '1.7';
    $android->numLicences = 2;

    $cart = new \Xibo\Platform\Entity\Shop($provider);
    $cart->addLineItem($android);
    $order = $cart->checkOut();

    echo json_encode($order) . PHP_EOL . PHP_EOL;

    // Access the quote
    $order->complete(1);

    echo json_encode($order) . PHP_EOL . PHP_EOL;*/

    //$provider->getLogger()->debug(json_encode((new \Xibo\Platform\Entity\Order($provider))->getById(6721)));
    //$provider->getLogger()->debug(json_encode((new \Xibo\Platform\Entity\Cloud($provider))->getThemes()));
    //$provider->getLogger()->debug(json_encode((new \Xibo\Platform\Entity\Cloud($provider))->getDomains()));
    $provider->getLogger()->debug(json_encode((new \Xibo\Platform\Entity\Cloud($provider))->getRegions()));
    //$provider->getLogger()->debug(json_encode((new \Xibo\Platform\Entity\Cloud($provider))->getInstances()));

} catch (Exception $e) {
    echo 'Exception: ' . PHP_EOL;
    echo $e->getCode()  . PHP_EOL;
    echo $e->getMessage()  . PHP_EOL;
    echo $e->getTraceAsString();
}