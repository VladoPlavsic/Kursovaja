<?php
class Database{
    private static $connection = null;

    private static function connect(){
        try{
            if (!self::$connection){
                self::$connection = new mysqli(getenv("DB_HOST"), getenv("DB_USER"), getenv("DB_PASSWORD"), getenv("DB_DATABASE"));
            }
        }catch (Throwable $e){
            die("Error raised trying to connect to database.\n".$e);
        }
    }

    private static function disconnect(){
        try{
            if (self::$connection){
                mysqli_close(self::$connection);
                self::$connection = null;
            }
        }catch (Throwable $e){
            die("Error raised trying to disconnect from database.\n".$e);
        }
    }

    public static function executeQuery($query){
        self::connect();
        $response = self::$connection->query($query);
        if (!$response){
            die("Query failed");
        }
        self::disconnect();
        return $response;
    }

    public static function getArticleContent($orderNum){
        self::connect();
        $response = self::executeQuery("call get_article(".$orderNum.")");
        self::disconnect();
        return mysqli_fetch_array($response)[1];
    }
}
?>