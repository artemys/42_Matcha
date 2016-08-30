<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   registration.c.php                                                :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

date_default_timezone_set('Europe/Paris');
// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');
// Afficher les erreurs et les avertissements

function ft_error($string)
{
	echo "<div class='margin_top_20 text-center col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 alert alert-danger'>".$string."</div>";
}


/* ***************************************************************************************** */

function ft_register($db, $username, $name_a, $name_b, $birthdate, $mail, $password, $activate)
{
	try
	{
		
		$new_password = password_hash($password, PASSWORD_DEFAULT);

		$stmt = $db->conn->prepare("INSERT INTO users(pseudo, firstname, lastname, birthdate, email, password, activate) VALUES(:username, :name_a, :name_b, :birthdate, :mail, :new_password, :activate)");
		$stmt->execute(array(":username"=>$username, ":name_a"=>$name_a, ":name_b"=>$name_b, ":birthdate"=>$birthdate, ":mail"=>$mail, ":new_password"=>$new_password, ":activate"=>$activate));
		$stmt = $db->conn->prepare("INSERT INTO profils(user_id) SELECT user_id FROM users WHERE pseudo = :username AND email = :mail");
		$stmt->execute(array(":username"=>$username, ":mail"=>$mail));
		return $stmt;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

function save_register_key($db, $username, $cle)
{
	try
	{
		$stmt = $db->conn->prepare("UPDATE users SET register_key = :cle WHERE pseudo=:username");
		$stmt->execute(array(':username'=>$username, ':cle'=>$cle));
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

function ft_password($password_a, $password_b)
{
	if ($_POST['password_a'] == $_POST['password_b'])
	{
		if ($password_a != '')
		{
			if (strlen($password_a) >= 8)
			{
				return (true);
			}
			else ft_error("Password must be at least 8 caracteres");

		}
	}
	return (false);
}

/* ***************************************************************************************** */

function ft_send_validation_mail($db, $username, $mail, $name_a, $name_b, $birthdate, $mail, $password_a)
{
	if (ft_register($db, $username, $name_a, $name_b, $birthdate, $mail, $password_a, 0))
	{
		$cle = md5(microtime(TRUE) * 100000);
		save_register_key($db, $username, $cle);
		$headers = "Content-type: text/html; charset=UTF-8";
		$nav = "signup";
		$statut = "activate";
		$sujet = "Activer votre compte";
		$message = "Bienvenue sur MATCHA, </br>
		 
		 	Pour activer votre compte, veuillez cliquer sur le lien ci dessous. </br>
		 
		<a	href='http://localhost:8080/?log=".urlencode($username)."&cle=".urlencode($cle)."&nav=".$nav."&statut=".$statut."'>Finalisez mon inscription</a> </br>
		</br>
											--------------- </br>
		</br>
			Ceci est un mail automatique, Merci de ne pas y répondre.";
		mail($mail, $sujet, $message, $headers);
	}
}

/* ***************************************************************************************** */

function ft_check_is_already_taken($db, $username, $mail, $name_a, $name_b, $birthdate, $mail, $password_a)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT pseudo, email FROM users WHERE pseudo =:username OR email=:mail");
		$stmt->execute(array(':username'=>$username, ':mail'=>$mail));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row['pseudo'] == $username)
		{
			ft_error("Sorry username already taken... Please choose another one !");
		}
		else if ($row['email'] == $mail)
		{
			ft_error("Sorry mail already taken.. Please use another one !");
		}
		else
		{
			ft_send_validation_mail($db, $username, $mail, $name_a, $name_b, $birthdate, $mail, $password_a);
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}


/* ***************************************************************************************** */

if (isset($_POST['validate']))
{
	if (isset($_POST['username']) && isset($_POST['name_a']) && isset($_POST['name_b']) && isset($_POST['birthdate']) && isset($_POST['mail']))
	{
		if (isset($_POST['password_a']) && isset($_POST['password_b']))
		{
			$username   = trim(htmlentities($_POST['username'  ]));
			$name_a     = trim(htmlentities($_POST['name_a'    ]));
			$name_b     = trim(htmlentities($_POST['name_b'    ]));
			$birthdate	= trim(htmlentities($_POST['birthdate' ]));
			$mail       = trim(htmlentities($_POST['mail'      ]));
			$password_a = trim(htmlentities($_POST['password_a']));
			$password_b = trim(htmlentities($_POST['password_b']));


			if (ft_password($password_a, $password_b))
			{
				if (filter_var($mail, FILTER_VALIDATE_EMAIL))
				{
					if (ft_check_is_already_taken($db, $username, $mail, $name_a, $name_b, $birthdate, $mail, $password_a))
						ft_error("operationreussie");
				}
				else ft_error("Please enter a validate email");
			}
			else
			{ 
				ft_error("Password must match");
			}
		}
		else 
			ft_error("Password are missing");
	}
	else ft_error("Some informations are missing");
}

/* ***************************************************************************************** */

include(MODULES.'/registration/'.VIEWS.'/registration.v.php');

/* ***************************************************************************************** */
?>
