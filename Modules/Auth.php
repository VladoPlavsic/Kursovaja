<?php

require __DIR__ . '/../vendor/autoload.php';
use \Firebase\JWT\JWT;

class WebToken{

    private static $algorithm = "HS256";

    public static function createToken($payload){
        return JWT::encode($payload, getenv("SECRET_KEY"), self::$algorithm);
    }

    private static function decodeToken($token){
        return (array)JWT::decode($token, getenv("SECRET_KEY"), array(self::$algorithm));
    }

    public static function checkToken(){
        if (!isset($_COOKIE["jwt"]))
            return false;
        $payload = self::decodeToken($_COOKIE["jwt"]);
        $response = Database::executeQuery("SELECT check_if_user_exists('".$payload['username']."','".$payload['email']."')");
        return mysqli_fetch_array($response)[0];
    }

}
?>