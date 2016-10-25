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
	echo "<div onclick='this.remove();' class='alert alert-danger'>".$string."</div>";
}
function ft_done($string)
{
	echo "<div onclick='this.remove();' class='alert alert-success'>".$string."</div>";
}

/* ***************************************************************************************** */


function ft_update_user_info($db, $data, $type)
{
	try
	{
		$old_name = $_SESSION['user'];
		if ($type == "password")
		{
			$data = password_hash($data, PASSWORD_DEFAULT);
		}
		$sql = "UPDATE users SET " . $type ." =  :data WHERE pseudo = :old_name";
		$stmt = $db->conn->prepare($sql);
		$stmt->execute(array(":data"=>$data, ":old_name"=>$old_name));
		if ($type == "pseudo")
		{
			$_SESSION['user'] = $data;
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */


function ft_check_is_already_taken($db, $data, $type)
{
	try
	{
		$sql = "SELECT * FROM users WHERE ".$type." = :data";
		$stmt = $db->conn->prepare($sql);
		$stmt->execute(array(":data"=>$data));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row['pseudo'] == $data)
		{
			ft_error("Sorry username already taken... Please choose another one !");
		}
		else if ($row['email'] == $data)
		{
			ft_error("Sorry mail already taken.. Please use another one !");
		}
		else
		{
			return true;
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
	if (isset($_POST['new_username']) && $_POST['new_username'] != "")
	{
		$username   = trim(htmlentities($_POST['new_username'  ]));
		if (ft_check_is_already_taken($db, $username, "pseudo"))
		{
			ft_update_user_info($db, $username, "pseudo");
			ft_done("Pseudo successfully updated");
		}
	}
	if (isset($_POST['new_name_a']) && $_POST['new_name_a'] != "")
	{
		$name_a     = trim(htmlentities($_POST['new_name_a']));
		ft_update_user_info($db, $name_a, "firstname");
		ft_done("Firstname successfully updated");
	}
	if(isset($_POST['new_name_b']) && $_POST['new_name_b'] != "")
	{
		$name_b     = trim(htmlentities($_POST['new_name_b'    ]));
		ft_update_user_info($db, $name_b, "lastname");
		ft_done("Lastname successfully updated");
	}
	if(isset($_POST['new_mail']) && $_POST['new_mail'] != "")
	{
		$mail       = trim(htmlentities($_POST['new_mail'      ]));
		if (filter_var($mail, FILTER_VALIDATE_EMAIL))
		{
			if (ft_check_is_already_taken($db, $mail, "email"))
			{
				ft_update_user_info($db, $mail, "email");
				ft_done("Email successfully updated");
			}
			else
				ft_error("Mail is already use");
		}
		else ft_error("Please enter a validate email");
	}
	if (isset($_POST['new_password_a']) && isset($_POST['new_password_b']) && $_POST['new_password_a'] != "" && $_POST['new_password_b'] != "")
	{
		$password_a = trim(htmlentities($_POST['new_password_a']));
		$password_b = trim(htmlentities($_POST['new_password_b']));

		if (ft_password($password_a, $password_b))
		{
			ft_update_user_info($db, $password_a, "password");
			ft_done("Password successfully updated");
		}
		else
		{ 
			ft_error("Password must match");
		}
	}
	// ft_error($error);
}

/* ***************************************************************************************** */

include(MODULES.'/settings/'.VIEWS.'/settings.v.php');

/* ***************************************************************************************** */

?>