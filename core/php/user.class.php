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
	// echo 'coucou';
	}

	}
?>
