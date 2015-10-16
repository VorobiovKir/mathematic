<?php 

	class 	Author
	{
		public static function 	check()
		{
			return 	(isset($_SESSION['us_id'])) ? true : false;
		}

		public static function 	isAdmin()
		{
			return 	(isset($_SESSION['us_status']) && $_SESSION['us_status'] === 'admin')
				? true : false;
		}
	}

 ?>