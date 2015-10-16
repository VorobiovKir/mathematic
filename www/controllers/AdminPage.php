<?php 

	require ROOT.'/controllers/MainPage.php';

	class 	AdminPage 	extends MainPage
	{

		private $error;
		private $Channels = array();

		protected function 	action()
		{
			require ROOT.'/actions/adminAct.php';	
		}

		protected function 	showContent()
		{
			require ROOT.'/pages/admin.php';
		}
	}

 ?>