<?php

declare(strict_types=1);

require dirname(__DIR__, 2) . "/includes/bootstrapper.php";

$url_path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$parts = explode("/", $url_path);

$resource = $parts[2];

$regno = $parts[3] ?? null;

if ($resource != "student"){

    http_response_code(404);

    echo json_encode(["message" => "No resource found at this endpoint!"]);
    
    exit; 

}

$database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

$student_gateway = new StudentGateway($database);

$jwt_signature = new JWTSignature($_ENV["SIGNED_KEY"]);

$auth = new Auth($student_gateway, $jwt_signature); 

if (!$auth->authenticate_with_jwt_signature()){
    
    exit;
     
}

$regno = $auth->get_student_id();

$student_controller = new StudentController($student_gateway); 

$student_controller->process_incoming_request($_SERVER["REQUEST_METHOD"], $regno);