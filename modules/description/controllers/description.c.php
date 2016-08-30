<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   description.c.php                                                 :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

function save_user_description($db, $bio_descr, $bio_owner)
{
	try
	{
		$stmt = $db->conn->prepare("UPDATE profils SET user_bio = :bio_descr WHERE user_id = (SELECT user_id FROM users WHERE  pseudo = :bio_owner)");
		$stmt->execute(array(':bio_descr'=>$bio_descr, ':bio_owner'=>$bio_owner));
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

function get_user_desc($db, $bio_owner)
{
	try
	{
		if (is_numeric($bio_owner))
		{
			$stmt = $db->conn->prepare("SELECT user_bio FROM profils WHERE user_id = :bio_owner");
		}
		else
		{
			$stmt = $db->conn->prepare("SELECT user_bio FROM profils WHERE user_id = (SELECT user_id FROM users WHERE  pseudo = :bio_owner)");
		}
		$stmt->execute(array(':bio_owner'=>$bio_owner));
		$useRow = $stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($useRow['user_bio']))
		{
			return($useRow['user_bio']);
		}
		else
		{
			return("Description");
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

if (isset($_SESSION['user']))
{
	$bio_owner = $_SESSION['user'];
	if (isset($_POST['Bio']) && isset($_POST['BioDescr']))
	{
		save_user_description($db, $_POST['BioDescr'], $bio_owner);
	}
}
else
{
	//error
}

/* ***************************************************************************************** */

include(MODULES.'/description/'.VIEWS.'/description.v.php');


/* ***************************************************************************************** */
?>
