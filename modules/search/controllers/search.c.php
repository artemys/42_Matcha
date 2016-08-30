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

function Age($date_naissance)
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

function get_user_search_by_tags_list($db, $user, $tags_list)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT * FROM profils WHERE user_tag ");
		$stmt->execute(array(":tags_list"=>$tags_list));
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC) && $row['pseudo'] != $user)
		{
			echo put_search_res($row);
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}

}

/* ***************************************************************************************** */

function get_user_search_by_location($db, $user, $klmless, $klmmore)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT * FROM users WHERE birthdate BETWEEN :ageless AND :agemore");
		$stmt->execute(array(":ageless"=>$ageless, ":agemore"=>$agemore));
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo put_search_res($row);
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
		$stmt = $db->conn->prepare("SELECT * FROM users WHERE birthdate BETWEEN :ageless AND :agemore");
		$stmt->execute(array(":ageless"=>$ageless, ":agemore"=>$agemore));
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo put_search_res($row);
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
		$stmt = $db->conn->prepare("SELECT * FROM users WHERE birthdate BETWEEN :ageless AND :agemore");
		$stmt->execute(array(":ageless"=>$ageless, ":agemore"=>$agemore));
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo put_search_res($row);
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}

}

/* ***************************************************************************************** */

if (isset($_POST['valider']))
{
	if (isset($_SESSION['user']))
	{
		$user = $_SESSION['user'];
		if (isset($_POST['age_interval_less']) && isset($_POST['age_interval_more']) && isset($_POST['score_interval_less']) && isset($_POST['score_interval_more']))
	 // && isset($_POST['klm_interval_less']) && isset($_POST['klm_interval_more']) && isset($_POST['tags_list']))
		{
			$ageless   = htmlentities($_POST['age_interval_less']);
			$agemore   = htmlentities($_POST['age_interval_more']);
			$scoreless = htmlentities($_POST['score_interval_less']);
			$scoremore = htmlentities($_POST['score_interval_more']);
			// $klmless   = htmlentities($_POST['klm_interval_less']);
			// $klmmore   = htmlentities($_POST['klm_interval_more']);
			// $tags 	   = htmlentities($_POST['tags_list']);

			if ($res = get_user_search($db, $user, $ageless, $agemore, $scoreless, $scoremore)) //, $klmless, $klmmore, $tags_list))
			{
				return ($res);
			}
			else
			{
				return ("No match found");
			}
		}
	}
}


/* ***************************************************************************************** */

include(MODULES.'/search/'.VIEWS.'/search.v.php');

/* ***************************************************************************************** */


?>
