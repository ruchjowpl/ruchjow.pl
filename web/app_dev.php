<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;
use Stermedia\AppDevSecurity\AppDevSecurityHandler;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
Debug::enable();

$securityHandler = new AppDevSecurityHandler();

if (!$securityHandler->isAccessible()) {
    header($securityHandler->getForbiddenHeader());
    exit($securityHandler->getForbiddenMessage());
} else {
    unset($securityHandler);
}

require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);