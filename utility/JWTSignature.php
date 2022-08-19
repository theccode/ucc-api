<?php
class JWTSignature {

    public function __construct(private string $signed_key){}

    public function encode(array $payload): string{

        $header = json_encode([

            "typ" => "JWT",

            "alg" => "sha256"

        ]);

        $header = $this->base64UrlEncode($header);

        $payload = json_encode($payload);

        $payload = $this->base64UrlEncode($payload);

        $signature = hash_hmac("sha256", $header. "." . $payload, $this->signed_key, true);

        $signature = $this->base64UrlEncode($signature);

        return $header . "." . $payload . "." . $signature;
    }

    public function decode(string $token): array {

        if (preg_match("/^(?<header>.+)\.(?<payload>.+)\.(?<signature>.+)$/", $token, $matches) !== 1){

            Throw new InvalidArgumentException("Invalid token format.");

        }

        $signature = hash_hmac(
            "sha256",
            $matches["header"] . "." . $matches["payload"], 
            $this->signed_key,
            true
        );


        $token_signature = $this->base64UrlDecode($matches["signature"]);

        if (!hash_equals($signature, $token_signature)){
            Throw new InvalidArgumentException; 
        }

        $payload = json_decode($this->base64UrlDecode($matches["payload"]), true);

        if ($payload["expires_in"] < Time()){
            Throw new TokenExpiredException;
        }

        return $payload;

    }

    private function base64UrlEncode(string $text): string {
        return str_replace(
            ["+", "/", "="],
            ["-", "_", ""],
            base64_encode($text)
        );
    }

    private function base64UrlDecode(string $text){
        return base64_decode(
           str_replace(
            ["-", "_"],
            ["+", "/"],
            $text
           )
        );
    }
    
}