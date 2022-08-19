<?php
class Database {

    private ?PDO $con = null; 

    public function __construct(private string $db_host, private string $db_name, private string $db_user, private string $db_pass){}

    public function get_connection_string(): PDO {

        $source_name = "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8";

        if ($this->con === null){

            $this->con = new PDO($source_name, "$this->db_user", "$this->db_pass",[

                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                PDO::ATTR_EMULATE_PREPARES => false,

                PDO::ATTR_STRINGIFY_FETCHES => false

            ]);       
            
        }

        return $this->con;
        
    }
}