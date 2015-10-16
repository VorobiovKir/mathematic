<?php 

	/**
	*	LOG OUT DESTROY $_SESSION, $_COOKIE
	*/
	if (isset($_GET['act']) && $_GET['act'] === 'logout') {
		
		if (!Author::check()) return;
		
		session_destroy();
		unset($_SESSION);
		setcookie('us_id', '', time() - 3600);
		setcookie('us_name', '', time() - 3600);
		setcookie('us_status', '', time() - 3600);

		header('Location: index.php');
		exit();
	}

	/**
	*	CHECK AUTHORIZATION
	*/
	if (isset($_SESSION['us_id'])) {

		header('Location: index.php?page=main');
		exit();

	} else {

		/**
		*	IF $_SESSION === FALSE, but $_COOKIE === TRUE
		*/
		if (isset($_COOKIE['us_id'])) {

			$_SESSION['us_id'] 		= $_COOKIE['us_id'];
			$_SESSION['us_name'] 	= $_COOKIE['us_name'];
			$_SESSION['us_status'] 	= $_COOKIE['us_status'];

			header('Location: index.php?page=main');
			exit();
		}
	}

	/**
	*	CREATE AUTHORIZATION
	*/
	$us_name 	= isset($_POST['us_name']) 		? htmlspecialchars(trim($_POST['us_name'])) : '';
	$us_pswd 	= isset($_POST['us_pswd']) 		? htmlspecialchars(trim($_POST['us_pswd'])) : '';
	$us_isCook	= isset($_POST['us_isCook']) 	|| false;
	$us_isPost 	= isset($_POST['us_isPost']) 	|| false;


	if ($us_isPost !== false) {
		
		/**
		*	check login
		*/
		$log_pattern = '/^[A-ZА-Яa-zа-я0-9_]{4,20}$/';

		if (!preg_match($log_pattern, $us_name)) {
			$this->error = 	"Ошибка ввода! Не правильное имя пользователя. <br> Имя пользователя не должно иметь запрещенных символов,"
							. "должно состоять минимум из 4ех символов, и не должно превышать 20ти символов";
			return;
		}

		/**
		*	check pswd
		*/
		if (strlen($us_pswd) < 4) {
			$this->error = 	"Ошибка ввода! <br> Пароль должен быть больше, чем 4 символа";
			return;
		}

		DataBase::connectDB();

		$q		= "SELECT * FROM `users` WHERE name = '{$us_name}' AND pswd = '".sha1($us_pswd)."' LIMIT 1";
		$res 	= mysql_query($q);

	
		if ($res && mysql_affected_rows() === 1) {
			$row = mysql_fetch_assoc($res);
			
			$status = ($row['isAdmin'] === '1') ? 'admin' : 'user';

			if ($us_isCook) {
				setcookie('us_id', $row['id'], time() + 3600);
				setcookie('us_name', $row['name'], time() + 3600);
				setcookie('us_status', $status, time() + 3600);
			}

			$_SESSION['us_id'] 		= $row['id'];
			$_SESSION['us_name'] 	= $row['name'];
			$_SESSION['us_status'] 	= $status;

			header('Location: index.php?page=main');
			exit();

		} else {

			$this->error = 	"Ошибка! Неверное имя пользователя или пароль";
			return;
		}

	}

 ?>