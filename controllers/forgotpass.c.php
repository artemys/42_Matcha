<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   forgotpass.c.php                                                  :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */


function save_restore_key($db, $id, $cle)
{
	try
	{
		$stmt = $db->conn->prepare("UPDATE users SET restore_key = :cle WHERE user_id = :id");
		$stmt->execute(array(":cle"=>$cle, ":id"=>$id));
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}

function send_email($db, $user_pseudo, $mail, $id)
{
		$cle = md5(microtime(TRUE) * 1000000);

	$headers = "Content-type: text/html; charset=UTF-8";
	$sujet = "Recuperation du Mot de passe de votre compte Matcha";
	$message = 'Bonjour, <br>
	 	<br>
	 	Pour recuperer votre mot de passe, veuillez cliquer sur le lien ci dessous. <br>
	 	<br>
		<a  href="http://localhost:8080/index.php?nav=ForgotPass&log='.urlencode($user_pseudo).'&cle='.urlencode($cle).'">Recuperation du mot de passe</a><br>
	 	<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--------------- <br>
		<br>
		Ceci est un mail automatique, Merci de ne pas y répondre.';

	mail($mail, $sujet, $message, $headers);
			echo '<div onclick="this.remove()"class="alert alert-success">Check your mail</div>'; 
	save_restore_key($db, $id, $cle);
}

function check_user($db, $user_pseudo, $mail)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT user_id, email FROM users WHERE pseudo = :user AND email = :mail");
		$stmt->execute(array(":user"=>$user_pseudo, ":mail"=>$mail));
		if($stmt->rowCount() == 1)
		{
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			send_email($db, $user_pseudo, $row['email'], $row['user_id']);
		}
		else
		{
			echo '<div onclick="this.remove()"class="alert alert-danger">Incorrect informations</div>'; 
		}
	}
	catch(PDOExeption $e)
	{
			echo $e->getMessage();
	}
}

function check_pass($db, $new_pass, $pseudo, $cle)
{
	if ($new_pass != '')
	{
		if (strlen($new_pass) >= 8)
		{
			try
			{
				$stmt = $db->conn->prepare("SELECT user_id FROM users WHERE pseudo = :pseudo AND restore_key = :cle");
				$stmt->execute(array(":pseudo"=>$pseudo, ":cle"=>$cle));
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($stmt->rowCount() == 1)
				{
					$new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
					$stmt = $db->conn->prepare("UPDATE users SET password = :new_pass, restore_key = NULL WHERE user_id = :id");
					$stmt->execute(array(":new_pass"=>$new_pass, ":id"=>$row['user_id']));
					echo '<div onclick="this.remove()"class="alert alert-success">Password updated succefully</div>'; 
				}
				else
				{
					echo '<div onclick="this.remove()"class="alert alert-danger">This recovery session has expired, please try again</div>';
					header('Refresh: 5; URL=index.php?nav=Signin');
				}
			}
			catch(PDOExeption $e)
			{
				echo $e->getMessage();
			}
		}
		else
			echo '<div onclick="this.remove()"class="alert alert-danger">Password must be at least 8 caracteres</div>';
	}
}
if (isset($_POST['btn_fpass']))
{
	if(isset($_POST['user']) && isset($_POST['mail']))
	{
		$user_pseudo = htmlentities($_POST['user']);
		$mail = htmlentities($_POST['mail']);
		if (!empty($user_pseudo) && !empty($mail))
		{
			check_user($db, $user_pseudo, $mail);
		}
		else
			echo '<div onclick="this.remove()"class="alert alert-danger">Please enter informations</div>'; 
	}
}
if (isset($_POST['modif']))
{
	if (isset($_POST['pass_a']) && isset($_POST['pass_b']) && !empty($_POST['pass_a']) && !empty($_POST['pass_b']) && isset($_GET['log']) && isset($_GET['cle']))
	{

		$new_pass_a = htmlentities($_POST['pass_a']);
		$new_pass_b = htmlentities($_POST['pass_b']);
		$pseudo     = $_GET['log'];
		$cle        = $_GET['cle'];
		if ($new_pass_a == $new_pass_b)
		{
			check_pass($db, $new_pass_a, $pseudo, $cle);
		}
		else
		{
			echo '<div onclick="this.remove()"class="alert alert-danger">Password must match</div>'; 
		}
	}
}
/* ***************************************************************************************** */

include(VIEWS.'/forgotpass.v.php');

/* ***************************************************************************************** */
?>
