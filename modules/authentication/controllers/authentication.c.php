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

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');
// Afficher les erreurs et les avertissements

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
				$_SESSION['user_session'] = $userRow['user_id'];
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

if (isset($_POST['validate']))
{
	$username = htmlentities($_POST['username']);
	$password = htmlentities($_POST['password']);

	if (login($db, $username, $password))
	{
		$_SESSION['user'] = $username;
		echo $_SESSION['user'];
		
		redirect('?nav=Home');
	}
	else
	{
		$error = "Wrong details";
	}
	echo '<div class="margin_top_20 text-center col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 alert alert-danger">'.$error.'</div>';
}
if (isset($_POST['forgotpass']))
{
	file_put_contents("coucou.txt", 'coucou');
}


/* ***************************************************************************************** */

include(MODULES.'/authentication/'.VIEWS.'/authentication.v.php');

/* ***************************************************************************************** */
?>
