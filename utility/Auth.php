<?php
class Auth {

    private string $student_id;

    public function __construct(private StudentGateway $student_gateway, private JWTSignature $jwt_signature){}

    public function authenticate_with_jwt_signature(): bool {
        
        if (empty($_SERVER["HTTP_AUTHORIZATION"])){ 

            http_response_code(400);

            echo json_encode(["message" => "No authorization header[e.g. Authorization: Bearer ...]."]);

            return false; 

        }

        if (!preg_match("/^Bearer\s+(.*)$/", $_SERVER["HTTP_AUTHORIZATION"], $matches)){ 

            http_response_code(400);

            echo json_encode(["message" => "Incomplete authorization header [e.g. Authorization:Bearer..."]);

            return false;

        }

        try {

            $data = $this->jwt_signature->decode($matches[1]);

        } catch(InvalidSignatureException){

            http_response_code(401);

            echo json_encode(["message" => "Invalid token signature."]);

            return false;

        } catch (TokenExpiredException){

            http_response_code(401);

            echo json_encode(["message" => "Token has expried."]);

            return false;

        } catch (Exception $e){

            http_response_code(400);

            echo json_encode(["message" => $e->getMessage()]);

            return false;

        }

        $this->student_id = $data["sub"];

        return true;

    }

    public function get_student_id(): string {
        
        return $this->student_id;

    }
}