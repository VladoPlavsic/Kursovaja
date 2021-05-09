<?php

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordRe = $_POST['passwordRe'];

if ($password != $passwordRe){
    setcookie("reason", "Паролы не совпадают!");
    header("Location: http://localhost:8080/sign");
    die();
}

$password = password_hash($password, PASSWORD_BCRYPT);

$response = Database::executeQuery("SELECT check_if_user_exists('".$username."','".$email."')");
$taken = mysqli_fetch_array($response)[0];

if (!$taken){
    $query = "INSERT INTO users (username, email, password) VALUES('$username', '$email', '$password')";
    Database::executeQuery($query);
    setcookie("jwt", WebToken::createToken(array(
        "aud" => "audience",
        "iat" => time(),
        "exp" => time() + 60*60*24,
        "username" => $username,
        "email" => $email
    )));
    header("Location: http://localhost:8080/home");
    die();
}elseif ($taken == 1){
    setcookie("reason", "Email уже используется", time() + 60*2);
    header("Location: http://localhost:8080/sign");
    die();
}elseif ($taken == 2){
    setcookie("reason", "Username уже используется", time() + 60*2);
    header("Location: http://localhost:8080/sign");
    die();
}else{
    
}

?>