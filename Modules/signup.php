<?php

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordRe = $_POST['passwordRe'];

if ($password != $passwordRe){
    setcookie("reason", "Паролы не совпадают!");
    header("Location: ".getenv('SITE_URL')."/sign");
    die();
}

$password = password_hash($password, PASSWORD_BCRYPT);

$response = Database::executeQuery("SELECT check_if_user_exists('".$username."','".$email."')");
$taken = mysqli_fetch_array($response)[0];

if (!$taken){
    $query = "call add_user('$username', '$password', '$email')";
    Database::executeQuery($query);
    setcookie("jwt", WebToken::createToken(array(
        "aud" => "audience",
        "iat" => time(),
        "exp" => time() + 60*60*24,
        "username" => $username,
        "email" => $email
    )));
    header("Location: ".getenv('SITE_URL')."/home");
    die();
}elseif ($taken == 1){
    setcookie("reason", "Email уже используется", time() + 60*2);
    header("Location: ".getenv('SITE_URL')."/sign");
    die();
}elseif ($taken == 2){
    setcookie("reason", "Username уже используется", time() + 60*2);
    header("Location: ".getenv('SITE_URL')."/sign");
    die();
}else{
    
}

?>