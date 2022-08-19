<?php
declare(strict_types=1);

require dirname(__DIR__, 2) . "/includes/bootstrapper.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){

    http_response_code(405);

    header('Allow: POST');

    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!array_key_exists("token", $data) ){
    http_response_code(400);
    echo json_encode(["message" => "Missing token"]);
    exit;
}

$signature = new JWTSignature($_ENV["SIGNED_KEY"]);

try {
    $payload = $signature->decode($data["token"]);
} catch(Exception){
    http_response_code(400);
    echo json_encode(["message" => "Invalid token"]);
    exit;
}

$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$token_factory = new TokenFactoryGateway($database, $_ENV["SIGNED_KEY"]);

$token_factory->delete($data["token"]);