<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   home.c.php                                                        :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */


function save_user_loc($db, $user_id, $user_loc)
{
	try
	{
		$user_loc_tab = explode(',', $user_loc);
		$stmt = $db->conn->prepare("SELECT user_true_long, user_true_lat FROM profils WHERE user_id = :user_id");
		$stmt->execute(array(':user_id'=>$user_id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row['user_true_long'] != $user_loc_tab[1] || $row['user_true_lat'] != $user_loc_tab[0])
		{
			$stmt = $db->conn->prepare("UPDATE profils SET user_true_long = :user_long, user_true_lat = :user_lat, user_true_city = :user_city, user_true_city_code = :user_city_code, user_true_country = :user_country WHERE user_id = :user_id");
			$stmt->execute(array(':user_id'=>$user_id, ':user_long'=>$user_loc_tab[1], ':user_lat'=>$user_loc_tab[0], ':user_city'=>$user_loc_tab[2], ':user_city_code'=>$user_loc_tab[3], ':user_country'=>$user_loc_tab[4]));
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}


/* ***************************************************************************************** */


function save_user_ip($db, $user_ip, $user_id, $user_loc)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT user_ip FROM users WHERE user_id = :user_id");
		$stmt->execute(array(':user_id'=>$user_id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row['user_ip'] != $user_ip)
		{
			$stmt = $db->conn->prepare("UPDATE users SET user_ip = :user_ip WHERE user_id = :user_id");
			$stmt->execute(array(':user_ip'=>$user_ip, ':user_id'=>$user_id));
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

if (isset($_SESSION['user']))
{
	include(VIEWS.'/home.v.php');
}
else 
{
	echo '<section class="content" id="Home">';
	include(AUTHENTICATION);
	echo '</section>';
}
if (isset($_POST['user_ip']) && isset($_SESSION['user_id']))
{
	save_user_ip($db, $_POST['user_ip'], $_SESSION['user_id']);
}
if (isset($_POST['user_loc']))
{
	save_user_loc($db, $_SESSION['user_id'], $_POST['user_loc']);
}
/* ***************************************************************************************** */


?>
