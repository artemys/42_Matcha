<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   settings.c.php                                                  :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */


function ft_error($string)
{
	echo "<div class='margin_top_20 text-center col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 alert alert-danger'>".$string."</div>";
}

/* ***************************************************************************************** */


function ft_update_user_info($db, $username, $name_a, $name_b, $mail, $password)
{
	try
	{
		$old_name = $_SESSION['user'];
		$new_password = password_hash($password, PASSWORD_DEFAULT);

		// $stmt = $db->conn->prepare("SELECT user_name FROM users WHERE pseudo = :old_name");
		// $stmt->execute(array(":old_name"=>$old_name));
		// $

		$stmt = $db->conn->prepare("UPDATE users SET pseudo = :username, firstname = :name_a, lastname = :name_b, email = :mail, password = :new_password WHERE pseudo = :old_name");
		$stmt->execute(array(":username"=>$username, ":name_a"=>$name_a, ":name_b"=>$name_b, ":mail"=>$mail, ":new_password"=>$new_password, ":old_name"=>$old_name));
		$_SESSION['user'] = $username;
		return $stmt;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */


function ft_check_is_already_taken($db, $username, $name_a, $name_b, $mail, $password_a)
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
			ft_update_user_info($db, $username, $name_a, $name_b, $mail, $password_a);
			// ft_send_validation_mail($db, $username, $mail, $name_a, $name_b, $birthdate, $mail, $password_a);
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}


/* ***************************************************************************************** */

function ft_password($password_a, $password_b)
{
	if ($_POST['new_password_a'] == $_POST['new_password_b'])
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

if (isset($_POST['modif']))
{
	if (isset($_POST['new_username']) && isset($_POST['new_name_a']) && isset($_POST['new_name_b']) && isset($_POST['new_mail']))
	{
		if (isset($_POST['new_password_a']) && isset($_POST['new_password_b']))
		{
			$username   = trim(htmlentities($_POST['new_username'  ]));
			$name_a     = trim(htmlentities($_POST['new_name_a'    ]));
			$name_b     = trim(htmlentities($_POST['new_name_b'    ]));
			$mail       = trim(htmlentities($_POST['new_mail'      ]));
			$password_a = trim(htmlentities($_POST['new_password_a']));
			$password_b = trim(htmlentities($_POST['new_password_b']));

			if (ft_password($password_a, $password_b))
			{
				if (filter_var($mail, FILTER_VALIDATE_EMAIL))
				{
					if (ft_check_is_already_taken($db, $username, $name_a, $name_b, $mail, $password_a))
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

include(MODULES.'/settings/'.VIEWS.'/settings.v.php');

/* ***************************************************************************************** */

?>