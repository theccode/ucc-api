<?php

$payload = [
    "sub" => $student["regno"],
    "expires_in" => Time() + 20
];

$signature = new JWTSignature($_ENV["SIGNED_KEY"]);
$renewed_token_expiry = Time() + 432000;

$access_token = $signature->encode($payload);
$renewed_token = $signature->encode([
    "sub" => $student["regno"],
    "expires_in" => $renewed_token_expiry
]);

echo json_encode(["access_token" => $access_token,
                    "new_token" => $renewed_token]);