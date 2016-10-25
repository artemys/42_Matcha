<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   logout.c.php                                                      :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

if ($user->is_loggedin() == true)
{
	try
	{
		$stmt = $db->conn->prepare("UPDATE users SET last_deconnection = NOW() WHERE pseudo = :user");
		$stmt->execute(array(':user'=>$_SESSION['user']));
	}
	catch(PDOExeption $e)
	{
			echo $e->getMessage();
	}
    $user->logout();
	$user->redirect("index.php");
}

/* ***************************************************************************************** */

include(VIEWS.'/logout.v.php');

/* ***************************************************************************************** */
?>
