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

function ft_error($string)
{
	echo "<div onclick='this.remove();'class='alert alert-danger'>".$string."</div>";
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
		ft_error($e->getMessage());
	}
}

/* ***************************************************************************************** */
/* PASSWORD CHEKER                                                                           */
/* ***************************************************************************************** */

function ft_password($password_a, $password_b)
{
	if ($_POST['password_a'] == $_POST['password_b'])
	{
		if ($password_a != '')
		{
			if (strlen($password_a) >= 8)
			{
				if (preg_match("#[0-9]#", $password_a))
				{
					return (true);
				}
				else
					ft_error("Your password must contain at least one numeric charactere");
			}
			else ft_error("Password must be at least 8 caracteres");
		}
	}
	return (false);
}

/* ***************************************************************************************** */
/* EXISTING CHECKER                                                                          */
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
			return (false);
		}
		else if ($row['email'] == $mail)
		{
			ft_error("Sorry mail already taken.. Please use another one !");
			return (false);
		}
		else if (ft_register($db, $username, $name_a, $name_b, $birthdate, $mail, $password_a, 0))
		{
			return (true);
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
					if (ft_check_is_already_taken($db, $username, $mail, $name_a, $name_b, $birthdate, $mail, $password_a) == true)
					{
						echo "<div onclick='this.remove();' class='alert alert-success'>Great ! You are register on Matcha</div>";
					}
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
