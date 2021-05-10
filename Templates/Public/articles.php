<?php include_once Route::getStaticFilesFolder()."/Shared/base.php" ?>
    
<?php if(WebToken::checkToken()): ?>
<div class="body">
    <ul>
        <?php foreach(Database::executeQuery("call get_availableArticles()") as $li) echo "<div style=\"display: flex; flex-direction:row;\"><a href=\"/articles&orderNum=".$li["orderNum"]."\"><li>".$li['articleName']."</li></a><div name=\"realOrder\" class=\"hide\"><p>".$li["orderNum"]."</p></div></div>" ?>
        <?php if(WebToken::checkIfAdmin()): ?>
            <div class="editContainer">
                <div>
                   <button id="edit">Edit</button>
                </div>
                <form action="availableArticles">
                    <div id="editInnerContainer" class="hide">
                        <div>
                            <input type="submit" formmethod="POST" value="Add"/>
                            <input type="submit" formmethod="GET" value="Delete"/>
                        </div>
                        <div>
                            <input name="orderNumber" type="number"  min="1" placeholder="id">
                            <input name="articleName" type="text" type="text" placeholder="Названые">
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </ul>
</div>

<?php else: ?>
<div class="body">
    Пожалуйста авторизируйтесь чтобы посмотреть наши статии.
</div>
<?php endif; ?>


<script>
	const edit = document.getElementById('edit');
	const editContainer = document.getElementById('editInnerContainer');
	const orderNumbers = document.getElementsByName('realOrder');
    var editing = false;

	edit.addEventListener('click', () => {
        if (editing){
		    editContainer.classList.add("hide");
		    editContainer.classList.remove("show");

            orderNumbers.forEach(orderNumber => {
                orderNumber.classList.add("hide");
                orderNumber.classList.remove("show");
            })

        }
        else{
		    editContainer.classList.add("show");
		    editContainer.classList.remove("hide");

            orderNumbers.forEach(orderNumber => {
                orderNumber.classList.add("show");
                orderNumber.classList.remove("hide");
            })

        }
        editing = !editing;
	});


</script>

<style> 
    
.container {
    padding-top: 20px;
}

<?php include_once Route::getStaticFilesFolder()."/styles/articles.css" ?>

</style>