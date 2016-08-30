<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   online.c.php                                                      :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

function get_online_user($db, $user)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT last_connection, last_deconnection FROM users WHERE user_id = :user");
		$stmt->execute(array(':user'=>$user));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$d = strtotime($row['last_deconnection']);
		$c = strtotime($row['last_connection']);
		$res =  $d - $c;
		// file_put_contents("online.txt", data)
		if($d > $c || $d == $c)
		{
			echo 'last connection : ' . $row['last_connection'];
			return (false);
			// return (true);
		}
		else
		{
			// echo 'last connection : ' . $row['last_connection'];
			return (true);
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}
/* ***************************************************************************************** */


/* ***************************************************************************************** */


include(MODULES.'/online/'.VIEWS.'/online.v.php');

/* ***************************************************************************************** */
?>
