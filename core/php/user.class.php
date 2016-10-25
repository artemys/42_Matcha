<?php

class User
{
	function is_loggedin()
	{
	   if (isset($_SESSION['user']))
	   {
	      return true;
	   }
	   	return false;
	}
	/* ***************************************************************** */
	
	function redirect($url)
	{
		header("Location: $url");
	}

	/* ***************************************************************** */

	function logout()
	{
		if (ini_get("session.use_cookies")) 
		{
    		$params = session_get_cookie_params();
    		setcookie(session_name(), '', time() - 42000,
        	$params["path"], $params["domain"],
        	$params["secure"], $params["httponly"]);
		}
		session_destroy();
	}

	/* ***************************************************************** */
	function get_user_id($db)
	{
		try
		{
			if (isset($_SESSION['user']))
			{
				$stmt = $db->conn->prepare("SELECT user_id FROM users WHERE :user_name = pseudo");
				$stmt->execute(array(':img_owner'=>$_SESSION['user']));
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				return ($row['user_id']);
			}
		}	
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	/* ***************************************************************** */
	function get_user_pic($db, $user_id)
	{
		try
		{
			if (isset($user_id))
			{
				$stmt = $db->conn->prepare("SELECT * FROM photo WHERE photo_auteur = :user_id");
				$stmt->execute(array(':user_id'=>$user_id));
				$count = $stmt->rowCount();
				if ($count > 0)
				{
					return (true);
				}
				else
				{
					return (false);
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	/* ***************************************************************** */
	function notify_entry($db, $owner_id, $guest_id, $content)
	{
		try
		{
			$stmt = $db->conn->prepare("INSERT INTO notif(owner_id, guest_id, content, seen) VALUES(:owner_id, :guest_id, :content, :seen)");
			$stmt->execute(array(":owner_id"=>$owner_id, ":guest_id"=>$guest_id, ":content"=>$content, ":seen"=>1));
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	/* ***************************************************************** */

	function db_call($sql, $db, $array_param, $row)
	{
		try
		{
			$stmt = $db->conn->prepare($sql);
			$stmt->execute($array_param);
			if ($row == 1)
			{
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
			}
			return($row);
		}
		catch(PDOExeption $e)
		{
			echo $e->getMessage();
		}
	}
	/* ***************************************************************** */
	function is_users_connected($db, $user_profil_id, $user_id)
	{
		$sql = "SELECT * FROM notif WHERE owner_id = :user_profil_id AND guest_id = :user_id AND content= 'conected' OR owner_id = :user_id  AND guest_id = :user_profil_id AND content = 'conected'";
		$param = array(":user_profil_id"=>$user_profil_id, ":user_id"=>$user_id);
		$row = db_call($sql, $db, $param, 1);
		if (isset($row) && !empty($row))
		{
			return(true);
		}
		else
		{
			return(false);
		}

	}
	/* ***************************************************************** */

	function get_profils_owner_name($db, $img_owner)
	{
		$sql = "SELECT pseudo FROM users WHERE user_id = :id";
		$param = array(":id"=>$img_owner);
		$pseudo = db_call($sql, $db, $param, 1);
		if (isset($pseudo['pseudo']) && !empty($pseudo['pseudo']))
		{
			return ($pseudo['pseudo']);
		}
		else
		{
			return (false);
		}
	}
	/* ***************************************************************** */

	function print_res($tab, $db)
	{
		$i = 0;
		while ($i <= count($tab))
		{
			try
			{
				$stmt = $db->conn->prepare("SELECT pseudo, birthdate FROM users INNER JOIN profils ON  users.user_id = profils.user_id WHERE users.user_id = :id");
				$stmt->execute(array(":id"=>$tab[$i]));
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if (isset($row))
				{
					echo '<section id="test">'.$row['pseudo']. '</section>';
				}
			$i++;
			}
			catch(PDOExeption $e)
			{
				echo $e->getMessage();
			}
		}
	}
	/* ***************************************************************** */

		function check_id($db, $id, $user_id)
		{
			$sql= "SELECT user_id FROM users WHERE user_id = :id";
			$param = array(":id"=>$id);
			$users = db_call($sql, $db, $param, 1);
			if ($users['user_id'] == $id && $user_id != $users['user_id'])
			{
				return (true);
			}
			else
			{
				return(false);
			}
		}
	}
	/* ***************************************************************** */
	function db_call($sql, $db, $array_param, $row)
	{
		try
		{
			$stmt = $db->conn->prepare($sql);
			$stmt->execute($array_param);
			if ($row == 1)
			{
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
			}
			return($row);
		}
		catch(PDOExeption $e)
		{
			echo $e->getMessage();
		}
	}

?>
