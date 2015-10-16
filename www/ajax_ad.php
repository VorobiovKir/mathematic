<?php 

	define('ROOT', dirname(__FILE__));
	require ROOT.'/components/DataBase.php';
	require ROOT.'/components/Author.php';

	session_start();
	DataBase::connectDB();

	if (!Author::isAdmin()) return;

	$action = isset($_POST['act']) ? htmlspecialchars(trim($_POST['act'])) : '';

	if ($action != '') {

		switch ($action) {
			
			case 'select_us':
				
				$q 		= "SELECT * FROM `users`";
				$res 	= mysql_query($q);

				if ($res && mysql_affected_rows() > 0) {

					$s 	= '';

					while ($row = mysql_fetch_assoc($res)) {
						
						$s 	.= '<p><a href="" onclick="return setId('.$row['id'].');">'.$row['name'].'</a></p>'; 
					}
				}

				echo $s;

				break;

			case 'select_mess':

				$id = isset($_POST['id']) ? intval($_POST['id']) : '';

				if ($id == '' || !is_int($id)) break;

				$s 		= '';
					
				$q 		= 	"SELECT "
    						. "messages.id AS id, "
    						. "messages.time,"
    						. "messages.content AS content, "
    						. "messages.from_id as from_id, messages.to_id AS opponent, "
    						. "(SELECT name FROM users WHERE users.id = from_id) AS from_name, "
    						. "(SELECT name FROM users WHERE users.id = opponent) AS to_name "
    						. "FROM messages "
    						. "WHERE messages.channel_id = 4 "
    						. " AND (messages.from_id = {$id} OR messages.to_id = {$id})"
    						. " ORDER BY messages.time";

				$res 	= 	mysql_query($q);

				if ($res && mysql_affected_rows() > 0) {
					while ($row = mysql_fetch_assoc($res)) {
							$s 	.=	'<p><span id="time">['.date('Y/m/d H:m:s', $row['time']).']</span>';
						if ($row['from_id'] === $row['opponent']) {
							$s 	.= 	'<span class="us_myself">myself';
						} elseif ($row['from_id'] == $id) {
							$s 	.= 	' to <span class="us_to" onclick="getPrivName();">'.$row['to_name'];
						} elseif ($row['opponent'] == $id) {
							$s 	.= 	' from <span class="us_from" onclick="getPrivName();">'.$row['from_name'];
						}
							
						$s .= 	':</span>'.$row['content'];
						$s .= ' <a href="" onclick="return del_mess('.$row['id'].');"><span class="glyphicon glyphicon-trash"></span></a>'; 
						$s .=	'</p>';
					}
				}

					echo $s;

				break;

			case 'delete':

				if (!Author::isAdmin()) break;

				$mes_id 	= isset($_POST['mes_id']) ? intval($_POST['mes_id']) : '';
				if ($mes_id == '' || !is_int($mes_id)) break;

				$q 		= "DELETE FROM `messages` WHERE id = ". mysql_escape_string($mes_id);
				$res 	= mysql_query($q);
				
				break;
			
			default:
				# code...
				break;
		}
	}

 ?>