<?php
class StudentController {

    public function __construct(private StudentGateway $student_gateway){}

    public function process_incoming_request(string $request_method, ?string $regno): void{

        if ($regno == null){

            if ($request_method == "GET"){

                echo "SHOW";

            } 
            
            if ($request_method == "POST"){

                echo "CREATED";

            }

        } else {

           switch($request_method){

                case "GET":
                    
                    echo json_encode($this->student_gateway->get_by_regno($regno));

                    break;

                case "PATCH":

                    echo "UPDATE $regno";

                    break;

                case "DELETE":

                    echo "DELETE $regno";

                    break;

           }
        }
    }
}