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

$regno = $payload["sub"];

$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$renewed_token_factory = new TokenFactoryGateway($database, $_ENV["SIGNED_KEY"]);

$renewed_token = $renewed_token_factory->get_by_token($data["token"]);

if ($renewed_token === false){
    http_response_code(400);
    echo json_encode(["message" => "Invalid token - Not found in the whitelist."]);
    exit;
}

$student_gateway = new StudentGateway($database);

$student = $student_gateway->get_by_regno($regno);

if ($student === false){
    http_response_code(404);
    echo "No Available resource for $regno";
    exit;
}

require dirname(__DIR__, 2) . '/includes/tokens.php';

$token_factory = new TokenFactoryGateway($database, $_ENV["SIGNED_KEY"]);

$token_factory->delete($data["token"]);

$token_factory->create($renewed_token, $renewed_token_expiry);