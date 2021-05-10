<div class="container">
	<p class="lead">Курсовой проект</p>
	<div class="header-bar">
		<h1 class="logo"><a href="/">K</a></h1>
		<ul class="slider-menu">
			<a href="/articles"><li>Статьи</li></a>
		</ul>
        <ul class="slider-menu">
			<?php if (WebToken::checkToken()):?>
				<form name="logOut" action="logout" method="GET">
					<li onClick="document.forms['logOut'].submit();">Выйти</li>
				</form>
			<?php else: ?>
            	<a href="/sign"><li>Войти</li></a>
            	<a href="/sign"><li>Зарегистрироваться</li></a>
			<?php endif; ?>
        </ul>
	</div>
</div>

<style> 
    <?php include_once Route::getStaticFilesFolder()."/styles/base.css" ?>
</style>