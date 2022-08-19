<?php

class TokenFactoryGateway {
    private PDO $con;
    private string $key;

    public function __construct(Database $database, string $key){
        $this->con = $database->get_connection_string(); 
        $this->key = $key;
    }

    public function create(string $token, int $expires_in): bool {

        $token_hash = hash_hmac("sha256", $token, $this->key);

        $sql = "INSERT INTO `token_whitelist` (token_hash, expires_in) VALUES(:token_hash, :expires_in)";

        $stmt = $this->con->prepare($sql);

        $stmt->bindValue(":token_hash", $token_hash, PDO::PARAM_STR);

        $stmt->bindValue(":expires_in", $expires_in, PDO::PARAM_INT);

        return $stmt->execute();

    }

    public function delete($token): int {

        $token_hash = hash_hmac("sha256", $token, $this->key);

        $sql = "DELETE FROM `token_whitelist` WHERE `token_hash` =:token_hash";

        $stmt = $this->con->prepare($sql);

        $stmt->bindValue(":token_hash", "$token_hash", PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount();

    }

    public function get_by_token($token): array | false {

        $token_hash = hash_hmac("sha256", $token, $this->key);

        $sql = "SELECT * FROM `token_whitelist` WHERE `token_hash` = :token_hash";

        $stmt = $this->con->prepare($sql);

        $stmt->bindValue(":token_hash", $token_hash, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function free_expired_tokens(): int {

        $sql = "DELETE FROM `token_whitelist` WHERE `expires_in` < UNIX_TIMESTAMP() ";

        $stmt = $this->con->query($sql);

        return $stmt->rowCount();

    }
}