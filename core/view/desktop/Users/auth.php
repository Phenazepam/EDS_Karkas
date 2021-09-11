<html>
<head>
	<title></title>

	<meta http-equiv="Content-Type" content="text/html; charset=Utf-8">	
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="/template/standart/css/bootstrap.min.css">
	<link rel="stylesheet" href="/template/standart/css/bootstrap_col_5.css">
	<link rel="stylesheet" href="/template/standart/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="/template/standart/css/main.css">
	
	<script src="/template/standart/js/jquery-1.11.0.min.js"></script>
	<script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script>
	<script src="/template/standart/js/bootstrap.min.js"></script>
</head>
<body>
<div class="center-block container">
	<div class="row">
		<div class="col-lg-12 visible-lg">
			<br><br><br><br>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-lg-offset-4">
			<form method="post">
			  <div class="form-group">
			    <label for="login">Имя пользователя</label>
			    <input type="text" name="user[login]" class="form-control" id="login" placeholder="Логин">
			  </div>
			  <div class="form-group">
			    <label for="password">Пароль</label>
			    <input type="password" name="user[password]" class="form-control" id="password" placeholder="Пароль">
			  </div>
			  <button type="submit" class="btn btn-default">Войти</button>
			  <input type="hidden" name="action" value="user.auth.do">
			</form>
		</div>
	</div>
</div>
</body>
</html>

