<?php

	session_start();

	define('ROOT', dirname(__FILE__));

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require ROOT.'/components/NavMenu.php';
	require ROOT.'/components/DataBase.php';
	require ROOT.'/components/Author.php';


	
	/**
	* 	Set default page
	*/
	$page = "main";

	/**
	*	validate $page on available words
	* 	and if all 'ok' set new value 
	*/
	$AllowPageName 	= array
						(
							'main'	, 
							'author', 
							'admin'
						);

	if 	(isset($_GET['page']) 	&& 	in_array($_GET['page'], $AllowPageName, true)) {
		$page 	= $_GET['page'];
	}

	/**
	*	Join controller
	*/
	$className 	= ucwords($page).'Page';
	$classDir 	= ROOT.'/controllers/'.$className.'.php';
	require $classDir;


	/**
	*	Create Navigation Menu
	*/
	$Navig = new NavMenu();
	$Navig->addLogo('Mathematic');
	
	if (Author::check()) {

		if (Author::isAdmin()) 	$Navig->addItem('Личный кабинет', 'admin');

		$Navig->addItem('Выйти', 'author&act=logout');
	} else {
		$Navig->addItem('Войти', 'author');
	}

	
	/**
	*	Join Navigation Menu with Controller 
	*/
	$Page = new $className($Navig);

	/**
	*	going our Controller
	*/
	$Page->showPage();

 ?>

