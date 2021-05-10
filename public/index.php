<?php
$errors = array();


// Incldue environment
include(__DIR__.'/../Modules/DotEnv.php');
use DevCoder\DotEnv;
$env_path = __DIR__ . '/../.env';
$env = new DotEnv($env_path);
$env->load();

// Include router class
include(__DIR__.'/../Modules/Router.php');

// Set our static files folder
Route::setStaticFilesFolder(realpath(__DIR__.'/../Templates'));
Route::setModuleFilesFolder(realpath(__DIR__.'/../Modules'));
Route::setRootFilesFolder(realpath(__DIR__.'/..'));

// Include database class
include(Route::getModuleFilesFolder().'/Database.php');

// Include token authentication class
include(Route::getModuleFilesFolder().'/Auth.php');

// Set path not found and method not allowed callbacks
Route::pathNotFound(function(){
    echo "404";
});

Route::methodNotAllowed(function() {
    echo "405";
});

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

// Get article
Route::add("/articles&orderNum=([0-9]*)", function($orderNum){
    $exists = mysqli_fetch_array(Database::executeQuery("SELECT check_availableArticleExists(".$orderNum.")"));
    if(!$exists[0])
        echo "404";
    else
        include_once Route::getStaticFilesFolder().'/Public/article.php';
}, 'get');

Route::add("/availableArticles", function(){
    if(WebToken::checkIfAdmin()){
        Database::executeQuery("call delete_availableArticle(".$_GET["orderNumber"].")");
        header("Location: http://localhost:8080/articles");
        die();
    }
    else
        echo "Forbidden";
}, 'get');

Route::add("/availableArticles", function(){
    if(WebToken::checkIfAdmin()){
        Database::executeQuery("call add_availableArticle(".$_POST['orderNumber'].",'".$_POST['articleName']."')");
        header("Location: http://localhost:8080/articles");
        die();
    }
    else
        echo "Forbidden";
}, 'post');

Route::add("/editArticle", function(){
    if(WebToken::checkIfAdmin()){
        $exists = mysqli_fetch_array(Database::executeQuery("SELECT check_article_exists(".$_POST['orderNum'].")"));
        if ($exists[0]){
            Database::executeQuery("call update_article(".$_POST['orderNum'].", '".$_POST['editor']."')");
        }else{
            Database::executeQuery("call add_article(".$_POST['orderNum'].", '".$_POST['editor']."')");
        }
        header("Location: http://localhost:8080/articles&orderNum=".$_POST['orderNum']."");
        die();
    }
    else
        echo "Forbidden";
}, 'post');

Route::run('/');

?>