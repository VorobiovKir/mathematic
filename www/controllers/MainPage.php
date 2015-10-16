<?php 

	class 	MainPage
	{
		/**
		*	set Navigation object
		*/
		private $Navigation;

		/**
		*	All channels
		*/
		private $Channels = array();

		public function 	__construct(NavMenu $nav)
		{
			$this->Navigation = $nav;
		}

		protected function 	action()
		{
			require ROOT.'/actions/mainAct.php';
		}

		protected function 	showHeader() 
		{
			require ROOT.'/pages/header.php';
		}

		protected function 	showNav()
		{
			echo $this->Navigation->show();
		}

		protected function 	showContent()
		{
			if (!empty($this->Channels)) {
				require ROOT.'/pages/main.php';
			} else {
				require ROOT.'/pages/error.html';
			}
		}

		protected function 	showFooter()
		{
			require ROOT.'/pages/footer.php';
		}

		public function 	showPage()
		{
			$this->action();
			$this->showHeader();
			$this->showNav();
			$this->showContent();
			$this->showFooter();
		}
	}

 ?>