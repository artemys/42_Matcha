<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   information.c.php                                                 :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

function save_user_informations($db, $user_sexuality, $user_gender, $info_owner)
{
	try
	{
		$stmt = $db->conn->prepare("UPDATE profils SET user_sexuality = :user_sexuality, user_gender = :user_gender WHERE user_id = (SELECT user_id FROM users WHERE  pseudo = :info_owner)");
		$stmt->execute(array(':user_sexuality'=>$user_sexuality, ':user_gender'=>$user_gender, ':info_owner'=>$info_owner));
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

function get_user_gender($db, $info_owner)
{
	if (isset($info_owner))
	{
		$stmt = $db->conn->prepare("SELECT user_gender FROM profils WHERE user_id = (SELECT user_id FROM users WHERE  pseudo = :info_owner)");
		$stmt->execute(array(':info_owner'=>$info_owner));
		$useRow = $stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($useRow['user_gender']))
		{
			file_put_contents("gender.txt", $useRow['user_gender']);
			if ($useRow['user_gender'] == 1)
			{
				return("a men.");
			}
			else if ($useRow['user_gender'] == 2)
			{
				return("a woman.");
			}
			else if ($useRow['user_gender'] == 3)
			{
				return("of my own kind.");
			}
		}
		else
		{
			return("");
		}
	}
}

/* ***************************************************************************************** */

function get_user_sexuality($db, $info_owner)
{
	if (isset($info_owner))
	{
		$stmt = $db->conn->prepare("SELECT user_sexuality FROM profils WHERE user_id = (SELECT user_id FROM users WHERE  pseudo = :info_owner)");
		$stmt->execute(array(':info_owner'=>$info_owner));
		$useRow = $stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($useRow['user_sexuality']))
		{
			if ($useRow['user_sexuality'] == 1)
			{
				return("is a men.");
			}
			else if ($useRow['user_sexuality'] == 2)
			{
				return("is a woman.");
			}
			else if ($useRow['user_sexuality'] == 3)
			{
				return("either are own kind");
			}
		}
		else
		{
			return("");
		}
	}
}
/* ***************************************************************************************** */

if (isset($_POST['info']))
{
	$user_sexuality = $_POST['sexuality'];
	$user_gender	= $_POST['gender'];
	if (isset($_SESSION['user']))
	{
		$info_owner	= $_SESSION['user'];
		save_user_informations($db, $user_sexuality, $user_gender, $info_owner);
	}
	else
	{
		//error
	}
}

/* ***************************************************************************************** */

include(MODULES.'/information/'.VIEWS.'/information.v.php');

/* ***************************************************************************************** */
?>
