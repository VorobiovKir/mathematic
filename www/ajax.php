<?php 
	
	define('ROOT', dirname(__FILE__));
	require ROOT.'/components/DataBase.php';
	require ROOT.'/components/Author.php';

	session_start();
	DataBase::connectDB();

	$action = isset($_POST['act']) ? htmlspecialchars(trim($_POST['act'])) : '';

	if ($action != '') {

		$channel 	= isset($_POST['channel']) ? 
						mysql_real_escape_string(htmlspecialchars(trim($_POST['channel']))) : '';

		$msg 		= isset($_POST['msg']) ? 
						mysql_real_escape_string(htmlspecialchars(trim($_POST['msg']))) : '';

		$us_id 		= isset($_POST['us_id']) ? 
						mysql_real_escape_string(htmlspecialchars(trim($_POST['us_id']))) : '';
		
		if ($channel == '') break;

		switch ($action) {
			case 'select':
				
				$q 		= 	"SELECT "
							. "messages.id AS id, "
							. "messages.content AS content, "
							. "users.name AS name "
							. " FROM `messages`, `users` "
							. "WHERE messages.from_id = users.id AND channel_id = ".$channel." ORDER BY messages.time";

				if ($channel === '4' && $us_id != '') {
					
					$s = '';
					
					$q 		= 	"SELECT "
    							. "messages.id AS id, "
    							. "messages.content AS content, "
    							. "messages.from_id as from_id, messages.to_id AS opponent, "
    							. "(SELECT name FROM users WHERE users.id = from_id) AS from_name, "
    							. "(SELECT name FROM users WHERE users.id = opponent) AS to_name "
    							. "FROM messages "
    							. "WHERE messages.channel_id = {$channel} "
    							. " AND (messages.from_id = {$us_id} OR messages.to_id = {$us_id})"
    							. " ORDER BY messages.time";

					$res 	= 	mysql_query($q);

					if ($res && mysql_affected_rows() > 0) {
						while ($row = mysql_fetch_assoc($res)) {
							/* if $row['from_id'] === $row['opponent']*/
							if ($row['from_id'] === $row['opponent']) {
								$s 	.= 	'<p><span class="us_myself">myself';
							} elseif ($row['from_id'] == $us_id) {
								$s 	.= 	'<p> to <span class="us_to" onclick="getPrivName();">'.$row['to_name'];
							} elseif ($row['opponent'] == $us_id) {
								$s 	.= 	'<p> from <span class="us_from" onclick="getPrivName();">'.$row['from_name'];
							}
							
							$s .= 	':</span>'.$row['content'];
							if (Author::isAdmin()) $s .= ' <a href="" onclick="return del_mess('.$row['id'].');"><span class="glyphicon glyphicon-trash"></span></a>'; 
							$s .=	'</p>';
						}
					}

					echo $s;
					break;
				}

				$res 	= mysql_query($q);
				
				$s 	= '';

				if ($res && mysql_affected_rows() > 0) {
					while ($row = mysql_fetch_assoc($res)) {
						$s .= '<p><span class="us_name" onclick="getPrivName();">'.$row['name'].':</span> '.$row['content'];
						
						if (Author::isAdmin()) { 
							$s .= ' <a href="" onclick="return del_mess('.$row['id'].');"><span class="glyphicon glyphicon-trash"></span></a>'; 
						}

						$s .='</p>';
					}
				} else {
					$s = '<p class="nothing">Пока здесь никто ничего не писал...</p>';
				}

				echo $s;
				break;
			
			case 'insert':

				$privPattern = "/^(Private: )([A-ZА-Яa-zа-я0-9_]{4,20})(,)(.*)/i";

				if (preg_match($privPattern, $msg)) {

					$user_to = preg_replace($privPattern, "$2", $msg);
					$new_msg = trim(preg_replace($privPattern, "$4", $msg));

					$q 		= 	"SELECT * FROM `users` WHERE name = '".
								mysql_escape_string($user_to)."' LIMIT 1";
					$res 	= 	mysql_query($q);

					if ($res && mysql_affected_rows() > 0) {
						
						$row 		= mysql_fetch_assoc($res);
						$user_to_id = $row['id'];

						$q 		= 	"INSERT INTO `messages` (`time`, `content`, `from_id`, `to_id`, `channel_id`)".
									" VALUES(".time().", '{$new_msg}', '{$us_id}', {$user_to_id}, '4')";
						$res 	= mysql_query($q);  
						break;
					}

				}

				
				if ($msg == '' || $us_id == '') break;

				$q 		= 	"INSERT INTO `messages` (`time`, `content`, `from_id`, `channel_id`)".
							" VALUES(".time().", '{$msg}', '{$us_id}', '{$channel}')";
				
				$res 	= mysql_query($q);

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