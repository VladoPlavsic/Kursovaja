<?php
$errors = array();


// Incldue environment
include(__DIR__.'/../Modules/DotEnv.php');
use DevCoder\DotEnv;
(new DotEnv(__DIR__ . '/../.env'))->load();

// Include router class
include(__DIR__.'/../Modules/Router.php');

// Set our static files folder
Route::setStaticFilesFolder(realpath(__DIR__.'/../Templates'));
Route::setModuleFilesFolder(realpath(__DIR__.'/../Modules'));

// Include database class
include(Route::getModuleFilesFolder().'/Database.php');

// Include token authentication class
include(Route::getModuleFilesFolder().'/Auth.php');

// Add base route (startpage)
Route::add('/',function(){
    include_once Route::getStaticFilesFolder().'/Public/home.php';
}, 'get');

Route::add('/home',function(){
    include_once Route::getStaticFilesFolder().'/Public/home.php';
}, 'get');

// Authentication forms
Route::add('/sign',function(){
    include_once Route::getStaticFilesFolder().'/Public/sign.php';
}, 'get');

Route::add('/signup', function(){
    include_once Route::getModuleFilesFolder().'/signup.php';
}, 'post');

Route::add('/signin', function(){
    include_once Route::getModuleFilesFolder().'/signin.php';
}, 'post');

Route::add("/logout", function(){
    setcookie("jwt", false);
    header("Location: http://localhost:8080/home");
    die();
}, 'get');

// Get articles
Route::add('/articles',function(){
    include_once Route::getStaticFilesFolder().'/Public/articles.php';
}, 'get');

// Accept only numbers as parameter. Other characters will result in a 404 error
Route::add('/foo/([0-9]*)/bar',function($var1){
    echo $var1.' is a great number!';
});

Route::run('/');

?>