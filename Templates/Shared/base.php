<html>

    <head>
        <!-- Include styles -->
        <style>
            <?php 
            foreach (glob(Route::$staticFilesFolder."/styles/*.css") as $styleSheet)
                include_once $styleSheet
            ?>
        </style>
    </head> 
    <body>
        <?php include_once Route::$staticFilesFolder."/Shared/head.php" ?>
        

    </body>
</html>