<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   score.c.php       	                                               :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

function get_user_score($db, $user_id)
{
	try
	{
		// if (isset($_GET['id']))
		// {
		// 	$user_id = $_GET['id'];
		// }
		// else if (isset($_SESSION['user_id']))
		// {
		// 	$user_id = $_SESSION['user_id'];
		// }
		// if (isset($user_id))
		// {
			$stmt = $db->conn->prepare("SELECT user_score FROm profils WHERE user_id = :user_id");
			$stmt->execute(array(':user_id'=>$user_id));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if (isset($row))
			{
				return ($row['user_score']);
			}
			else
			{
				return (0);
			}
		// }
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */
if (isset($_GET['id']))
{
	$user_id = $_GET['id'];
}
else if (isset($_SESSION['user_id']))
{
	$user_id = $_SESSION['user_id'];
}
if (isset($user_id))
{
	get_user_score($db, $user_id);
}

/* ***************************************************************************************** */

include(MODULES.'/score/'.VIEWS.'/score.v.php');

/* ***************************************************************************************** */

?>