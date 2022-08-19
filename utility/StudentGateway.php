<?php
class StudentGateway {

    private PDO $con;

    public function __construct(private Database $database){

        $this->con = $database->get_connection_string();
        
    }

    public function verify_by_regno(string $regno): array | false {

        $sql = "SELECT * FROM `useraccount` WHERE `regno` = :regno";

        $pdo_stmt = $this->con->prepare($sql);

        $pdo_stmt->bindValue(":regno", $regno, PDO::PARAM_STR);

        $pdo_stmt->execute();

        return $pdo_stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function get_by_regno(string $regno): array | false {

        $students_db_query = "SELECT * FROM `students_db` WHERE `regno` = :regno";

        $major_db_query = "SELECT `comments` FROM `major_db` WHERE `majorid` = :majorid";

        $prog_db_query = "SELECT `short_name` FROM `prog_db` WHERE `progid` = :progid";

        $hall_db_query = "SELECT `hall` FROM `halls` WHERE `hallid` = :hallid";

        //generic
        $pdo_stmt = $this->con->prepare($students_db_query);

        $pdo_stmt->bindValue(":regno", $regno, PDO::PARAM_STR);

        $pdo_stmt->execute();

        $result =  $pdo_stmt->fetch(PDO::FETCH_ASSOC);

        //major

        $major_db_stmt = $this->con->prepare($major_db_query);

        $major_db_stmt->bindValue(":majorid", $result["majorid"], PDO::PARAM_STR);

        $major_db_stmt->execute();

        $major_db_result = $major_db_stmt->fetch(PDO::FETCH_ASSOC);

        $major_db_result["major"] = $major_db_result["comments"];

        //program

        $prog_db_stmt = $this->con->prepare($prog_db_query);

        $prog_db_stmt->bindValue(":progid", $result["progid"], PDO::PARAM_STR);

        $prog_db_stmt->execute();

        $prog_db_result = $prog_db_stmt->fetch(PDO::FETCH_ASSOC);

        $prog_db_result["program"] = $prog_db_result["short_name"];

        //Hall

        $hall_stmt = $this->con->prepare($hall_db_query);

        $hall_stmt->bindValue(":hallid", $result["hallid"], PDO::PARAM_STR);

        $hall_stmt->execute();

        $hall_result = $hall_stmt->fetch(PDO::FETCH_ASSOC);

        $new_result = array_merge($result, $major_db_result, $prog_db_result, $hall_result);

        unset($new_result["short_name"]);
        
        unset($new_result["comments"]);

        return $new_result;

    }
}