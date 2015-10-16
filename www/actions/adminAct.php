<?php 

	if (!Author::isAdmin()) {
		
		header('Location: index.php');
		exit();
	}

	DataBase::connectDB();

	$q 		= "SELECT * FROM `channels`";
	$res 	= mysql_query($q);

	if ($res) {
		while ($row = mysql_fetch_assoc($res)) {
			$this->Channels[] = $row;
		}
	}

	/**
	*	Delete Channel
	*/
	if (isset($_GET['act']) && $_GET['act'] === 'del') {

		$id = isset($_GET['id']) ? intval($_GET['id']) : '';

		if ($id == '' || !is_int($id)) return;

		$q 		= "DELETE FROM `channels` WHERE id = ". mysql_escape_string($id);
		$res 	= mysql_query($q);

		if ($res) {
			header('Location: index.php?page=admin');
			exit();
		}
	}

	/**
	*	Create Channel
	*/
	if (isset($_POST['crt_chann'])) {

		$name = isset($_POST['chann_name']) ? htmlspecialchars(trim($_POST['chann_name'])) : '';

		if ($name == '') return;

		$q 		= "INSERT INTO `channels`(`name`) VALUES ('$name')";
		$res	= mysql_query($q);

		if ($res) {
			header('Location: index.php?page=admin');
			exit();
		}
	}

	/**
	*	Edit Channel
	*/
	if (isset($_POST['edt_chann'])) {

		$name 	= isset($_POST['chann_name']) ? htmlspecialchars(trim($_POST['chann_name'])) : '';
		$id 	= isset($_POST['chan_id']) ? intval($_POST['chan_id']) : '';

		if ($name == '') return;
		if ($id == '' || !is_int($id)) return;

		$q 		= "UPDATE `channels` SET `name`= '{$name}' WHERE id = ".mysql_escape_string($id);
		$res	= mysql_query($q);

		if ($res) {
			header('Location: index.php?page=admin');
			exit();
		}
	}

 ?>