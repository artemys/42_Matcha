<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   authentication.c.php                                              :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

/* ***************************************************************************************** */
/* SAVE USER LOC           																	 */
/* ***************************************************************************************** */
function get_save_user_localisation($db, $user_id)
{
	try
	{
		$stmt = $db->conn->prepare("UPDATE profils SET user_true_loc = :ip WHERE user_id = :user_id");
		$stmt->execute(array(':ip'=>$_SERVER['REMOTE_ADDR'], ':user_id'=>$user_id));
	}
	catch(PDOExeption $e)
	{
			echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

function update_connection_timer($db, $username)
{
	try
	{
		$stmt = $db->conn->prepare("UPDATE users SET last_connection = NOW() WHERE pseudo = :username");
		$stmt->execute(array(':username'=>$username));
	}
	catch(PDOExeption $e)
	{
			echo $e->getMessage();
	}
}
/* ***************************************************************************************** */

function login($db, $username, $password)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT * FROM users WHERE pseudo=:username LIMIT 1");
		$stmt->execute(array(':username'=>$username));
		$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($stmt->rowCount() > 0)
		{
			if (password_verify($password, $userRow['password']))
			{
				$_SESSION['user_id'] = $userRow['user_id'];
				$_SESSION['user'] 	 = $userRow['pseudo'];
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	catch (PDOException $e)
	{
		echo $e->getMessage();
	}
	return false;
}

/* ***************************************************************************************** */

function redirect($url)
{
	header("Location: $url");
}

/* ***************************************************************************************** */

if (isset($_POST['validate']) && isset($_POST['username']) && isset($_POST['password']))
{
	$username = htmlentities($_POST['username']);
	$password = htmlentities($_POST['password']);

	if (login($db, $username, $password))
	{
		update_connection_timer($db, $username);
		redirect("index.php?nav=Home");
	}
	else
	{
		$error = "Wrong details";
	}
	echo '<div class="alert alert-danger">'.$error.'</div>';
}



/* ***************************************************************************************** */

include(MODULES.'/authentication/'.VIEWS.'/authentication.v.php');

/* ***************************************************************************************** */
?>
