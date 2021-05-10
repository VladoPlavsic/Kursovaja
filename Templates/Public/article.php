<?php include_once Route::getStaticFilesFolder()."/Shared/base.php" ?>
    
<?php if(WebToken::checkToken()):?>
    <div class="body">
        <div class="article">
            <?php $content = Database::getArticleContent($orderNum); echo $content ?>
        </div>
        <?php if(WebToken::checkIfAdmin()):?>
            <button id="edit">Edit</button>  
            <form action="editArticle" method="POST">
                <div id="articleEditor" class="hide">
                    <!-- Incldue ckeditor using content delivery network -->
                    <script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
                    <textarea class="ckeditor" name="editor">
                        <?php echo $content ?>
                    </textarea>
                    <?php echo '<input type="hidden" name="orderNum" value="'.$orderNum.'"/>'?>
                    <input type="submit" value="Submit"/>
                </div>
            </form>
        <?php else: ?>
        <?php endif; ?>
    </div>

<?php else: ?>
    <div class="body">
        Пожалуйста авторизируйтесь чтобы посмотреть наши статии.
    </div>
<?php endif; ?>


<script>

    const editButton = document.getElementById("edit");
    const articleEditor = document.getElementById("articleEditor");
    var editing = false;

    editButton.addEventListener('click', () => {

        if (editing){
            articleEditor.classList.add("hide");
            articleEditor.classList.remove("show");
        }else{
            articleEditor.classList.add("show");
            articleEditor.classList.remove("hide");
        }

        editing = !editing;
    });

</script>

<style> 
    
.container {
    padding-top: 20px;
}

<?php include_once Route::getStaticFilesFolder()."/styles/article.css" ?>

</style>