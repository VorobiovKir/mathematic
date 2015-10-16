<?php 

	DataBase::connectDB();

	/**
	*	Check and show available channels
	*/
	if (!Author::check()) {
		$q = "SELECT * FROM `channels` WHERE isAvail = 1";
	} else {
		$q = "SELECT * FROM `channels`";
	}

	$res = mysql_query($q);
	
	if ($res) {
		while ($row = mysql_fetch_assoc($res)) {
			$this->Channels[] = $row;
		}
	}

 ?>