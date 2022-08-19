<?php
class ErrorHandler {

    public static function handle_errors (int $errno, string $errstr, string $errfile, int $errline){

        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);

    }

    public static function handle_exceptions(Throwable $exception) : void {
        http_response_code(500);
        echo json_encode([
            "code" => $exception->getCode(),
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine()
        ]);
    }
}