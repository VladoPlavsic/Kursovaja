<?php if(WebToken::checkToken()){
	header("Location: ".getenv('SITE_URL')."/");
	die();
}?>
<?php include_once Route::getStaticFilesFolder()."/Public/errors.php" ?>
<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form id="signupForm" action="signup" method="post">
			<h1>Создать аккаунт</h1>
			<div class="social-container">
			</div>
			<input name="username" type="text" placeholder="Name" />
			<input name="email" type="email" placeholder="Email" />
			<input name="password" type="password" placeholder="Password" />
			<input name="passwordRe" type="password" placeholder="Re-enter password" />
			<a></a>
			<button>Зарегистрироваться</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="signin" method="post">
			<h1>Войти</h1>
			<div class="social-container">
			</div>
			<input name="email" type="email" placeholder="Email" />
			<input name="password" type="password" placeholder="Password" />
			<a></a>
			<button>Войти</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Добро пожаловать!</h1>
				<p>Чтобы оставаться на связи с нами, войдите в систему, указав свою информацию</p>
				<button class="ghost" id="signIn">Войти</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Привет, друг!</h1>
				<p>Введите свои данные и отправтьесь в путешествие вместе с нами</p>
				<button class="ghost" id="signUp">Зарегистрироваться</button>
			</div>
		</div>
	</div>
</div>

<script>

	const signUpButton = document.getElementById('signUp');
	const signInButton = document.getElementById('signIn');
	const container = document.getElementById('container');

	signUpButton.addEventListener('click', () => {
		container.classList.add("right-panel-active");
	});

	signInButton.addEventListener('click', () => {
		container.classList.remove("right-panel-active");
	});
</script>

<style> 
    <?php include_once Route::getStaticFilesFolder()."/styles/sign.css" ?>
</style>