<?php 

	require ROOT.'/controllers/MainPage.php';

	class 	AuthorPage 	extends MainPage
	{

		private $error = null;

		protected function 	action()
		{
			require ROOT.'/actions/authorAct.php';	
		}

		protected function 	showContent()
		{
			require ROOT.'/pages/authorization.php';
		}
	}

 ?>