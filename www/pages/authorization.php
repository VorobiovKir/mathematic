<?php if ($this->error !== null): ?>
	<p class="bg-danger err"><?php echo $this->error; ?></p>
<?php endif ?>
<form action="index.php?page=author" method="POST">
	<div class="form-group">
    	<label for="exampleInputEmail1">Имя</label>
    	<input type="text" name="us_name" value="<?php if (isset($_POST['us_name'])) echo $_POST['us_name']; ?>" class="form-control" id="exampleInputEmail1" placeholder="Введите имя пользователя">
  	</div>
	<div class="form-group">
    	<label for="exampleInputPassword1">Пароль</label>
    	<input type="password" name="us_pswd" class="form-control" id="exampleInputPassword1" placeholder="Введите пароль">
  	</div>
  	<div class="checkbox">
    	<label>
      		<input type="checkbox" name="us_isCook"> Запомнить меня
    	</label>
  	</div>
  	<button type="submit" name="us_isPost" class="btn btn-default">Отправить</button>
</form>