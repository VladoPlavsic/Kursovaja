<?php

$email = $_POST["email"];
$password = $_POST["password"];

$record = Database::executeQuery("SELECT * FROM users WHERE email = '$email'");

$user = mysqli_fetch_array($record);

if(password_verify($password, $user["password"])){
    setcookie("jwt", WebToken::createToken(array(
        "aud" => "audience",
        "iat" => time(),
        "exp" => time() + 60*60*24,
        "username" => $user["usernane"],
        "email" => $user["email"]
    )));
    header("Location: http://localhost:8080/home");
    die();
}else{
    setcookie("reason", "Не верные данные", time() + 60*2);
    header("Location: http://localhost:8080/sign");
    die();
}


?>
