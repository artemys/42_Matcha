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
		$stmt = $db->conn->prepare("INSERT INTO profils(user_bio) VALUES(:bio_descr) WHERE user_id = SELECT user_id FROM users WHERE  pseudo = :bio_owner");
		$stmt->execute(array(':bio_descr'=>$bio_descr, ':bio_owner'=>$bio_owner));
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
