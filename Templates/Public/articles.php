<?php include_once Route::getStaticFilesFolder()."/Public/base.php" ?>
    
<?php if(WebToken::checkToken()): ?>
    Hello
<?php else: ?>
    Not hello
<?php endif; ?>


<style> 
    
.container {
    margin-top: 20px;
}

</style>