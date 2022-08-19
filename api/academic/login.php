<?php
declare(strict_types=1);

require dirname(__DIR__, 2) . "/includes/bootstrapper.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){

    http_response_code(405);

    header('Allow: POST');

    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if ($data === null){

    http_response_code(400);

    echo json_encode(["message" => "Request expects data"]);

    exit;
    
}

if (!array_key_exists("regno", $data) || !array_key_exists("password", $data)){
    http_response_code(400);
    echo json_encode(["message" => "Missing login credentials"]);
    exit;
}

$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$student_gateway = new StudentGateway($database);

$student_verify = $student_gateway->verify_by_regno($data["regno"]);

if ($student_verify === false){
    http_response_code(401);
    echo json_encode(["message" => "Invalid credentials"]);
    exit;
}

if ($student_verify["password"] !== md5($data["password"])){
    http_response_code(401);
    echo json_encode(["message" => "Invalid credentials!"]);
    exit;
}

$student = $student_gateway->get_by_regno($data["regno"]);

if ($student === false){
    http_response_code(404);
    echo "No Available resource for $data[regno]";
    exit;
}

require dirname(__DIR__, 2) . '/includes/tokens.php';

$token_factory = new TokenFactoryGateway($database, $_ENV["SIGNED_KEY"]);

$token_factory->create($renewed_token, $renewed_token_expiry);