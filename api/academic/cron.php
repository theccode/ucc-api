<?php

require dirname(__DIR__, 2) . "/includes/bootstrapper.php";

$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$token_factory_gateway = new TokenFactoryGateway($database, $_ENV["SIGNED_KEY"]);

echo $token_factory_gateway->free_expired_tokens(), "\n";