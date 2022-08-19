<?php

require dirname(__DIR__) . '/vendor/autoload.php';

set_error_handler("ErrorHandler::handle_errors");

set_exception_handler("ErrorHandler::handle_exceptions");

header("Content-type: application/json; charset:UTF-8");

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));

$dotenv->load();
