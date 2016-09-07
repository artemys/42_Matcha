<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   search.c.php                                                      :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

function birthdate_to_age($date_naissance)
{
    $arr1 = explode('-', $date_naissance);
 
    $user_y = $arr1[0];
    $user_m = $arr1[1];
    $user_d = $arr1[2];

    $arr2  = explode('/', date('d/m/Y'));
	$cur_d = $arr2[0];
    $cur_m = $arr2[1];
    $cur_y = $arr2[2];

    if(($user_m < $cur_m) || (($user_m == $cur_m) && ($user_y <= $cur_y)))
    return $cur_y - $user_y;

    return $cur_y - $user_y - 1;
}
/* ***************************************************************************************** */
function age_to_birthdate($age)
{
	$now = explode('/', date('d/m/Y'));
	return($now[2] - $age);
}

/* ***************************************************************************************** */

function get_user_search_by_tags($db, $user, $tags_list)
{
	$i = 0;
	$j = 0;
	$res = array();
	$tab = explode(',', $tags_list);
	while ($tab[$i] && $i < count($tab) - 1)
	{
		try
		{
			$stmt = $db->conn->prepare("SELECT user_id FROM profils WHERE user_tags LIKE :tag");
			$stmt->execute(array(":tag"=>'%'. $tab[$i] . '%'));
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				if ($row['user_id'] != $user)
				{
					$res[$j] = $row['user_id'];
				}
				$j++;
			}
		}
		catch(PDOExeption $e)
		{
			echo $e->getMessage();
		}
		$i++;
	}
	if (isset($res))
	{
		return ($res);
	}
	else
	{
		return (array(0));
	}
}

/* ***************************************************************************************** */

function get_user_search_by_location($db, $user, $klmless, $klmmore)
{
	try
	{
		$user_id = $_SESSION['user_id'];
		$i 		 = 0;
		
		$stmt = $db->conn->prepare("SELECT user_public_long, user_public_lat FROM profils WHERE user_id = :user_id");
		$stmt->execute(array(':user_id'=>$user_id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $db->conn->prepare("SELECT user_id FROM profils WHERE DEGREES(ACOS((SIN(RADIANS(:ulat))*SIN(RADIANS(user_public_lat)))+(COS(RADIANS(:ulat))*COS(RADIANS(user_public_lat))*COS(RADIANS(:ulong - user_public_long))))) * 111.13384 BETWEEN :klmless AND :klmmore");
		$stmt->execute(array(':ulong'=>$row['user_public_long'], ':ulat'=>$row['user_public_lat'], ':klmless'=>$klmless, ':klmmore'=>$klmmore));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			if ($row['user_id'] != $user_id)
			{
				$res[$i] = $row['user_id'];
			}
			$i++;
		}
		if (isset($res))
		{
			return ($res);
		}
		else
		{
			return (array(0));
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}

}
/* ***************************************************************************************** */


function get_user_search_by_score($db, $user, $scoreless, $scoremore)
{
	try
	{
		$res = array();
		$i = 0;

		$stmt = $db->conn->prepare("SELECT user_id FROM profils WHERE user_score BETWEEN :scoreless AND :scoremore");
		$stmt->execute(array(":scoreless"=>$scoreless, ":scoremore"=>$scoremore));
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$res[$i] = $row['user_id'];
			$i++;
		}
		if (isset($res))
		{
			return ($res);
		}
		else
		{
			return (array(0));
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}

}

/* ***************************************************************************************** */

function get_user_search_by_age($db, $user, $ageless, $agemore)
{
	try
	{
		$min = age_to_birthdate($ageless);
		$max = age_to_birthdate($agemore);
		$res = array();
		$i = 0;
		$stmt = $db->conn->prepare("SELECT user_id FROM users WHERE YEAR(birthdate) BETWEEN :max AND :min");
		$stmt->execute(array(":max"=>$max, ":min"=>$min));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$res[$i] = $row['user_id'];
			$i++;
		}
		if (isset($res))
		{
			return ($res);
		}
		else
		{
			return (array(0));
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}

}
/* ***************************************************************************************** */

/* ***************************************************************************************** */

if (isset($_POST['valider']))
{
	if (isset($_SESSION['user']) && isset($_SESSION['user_id']))
	{
		$user 			 = $_SESSION['user'];
		$user_id 		 = $_SESSION['user_id'];
		$i = 0;
		
		if (isset($_POST['score_interval_less']) && isset($_POST['score_interval_more']))
		{
			$scoreless 	 = htmlentities($_POST['score_interval_less']);
			$scoremore 	 = htmlentities($_POST['score_interval_more']);
			$match_score = get_user_search_by_score($db, $user, $scoreless, $scoremore);
		}
		if (isset($_POST['age_interval_less']) && isset($_POST['age_interval_more']))
		{

			$ageless   	 = htmlentities($_POST['age_interval_less']);
			$agemore   	 = htmlentities($_POST['age_interval_more']);
			$match_age 	 = get_user_search_by_age($db, $user, $ageless, $agemore);
		}
		if (isset($_POST['klm_interval_less']) && isset($_POST['klm_interval_more']))
		{
			$klmless   	 = htmlentities($_POST['klm_interval_less']);
			$klmmore   	 = htmlentities($_POST['klm_interval_more']);
			$match_loc 	 = get_user_search_by_location($db, $user, $klmless, $klmmore);
		}
		if (isset($_POST['selection']))
		{
			$tags 		 = htmlentities($_POST['selection']);
			$match_tag 	 = get_user_search_by_tags($db, $user_id, $tags);
		}
		// $salt = get_commun_user($match_score, $match_age, $match_loc, $match_tag);
		$salt = array($match_score, $match_age, $match_loc, $match_loc);
		while ($i < 3)
		{
			file_put_contents("test7536.txt", $salt[$i], FILE_APPEND);
			file_put_contents("test7536.txt", "\n", FILE_APPEND);
			$i++;
		}
		echo "<script> var final_tab= ". json_encode($salt)."</script>";
	}
}

/* ***************************************************************************************** */

include(MODULES.'/search/'.VIEWS.'/search.v.php');

/* ***************************************************************************************** */


?>
