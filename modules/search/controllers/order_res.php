<?php
/* ***************************************************************************************** */
/* AGE_TO_BIRTHDATE                                                                          */
/* ***************************************************************************************** */

function age_to_birthdate($age)
{
	$now = explode('/', date('d/m/Y'));
	return($now[2] - $age);
}
/* ***************************************************************************************** */
/* GET_USER_SEARCH_BY_TAGS                                                                   */
/* ***************************************************************************************** */

function get_user_search_by_tags($conn, $user, $tags_list)
{
	$i    = 0;
	$j    = 0;
	$res  = array();
	$tab  = explode(',', $tags_list);
	$size = count($tab) - 1;
	
	while ($i <= $size)
	{
		try
		{
			$stmt = $conn->prepare("SELECT user_id FROM profils WHERE user_tags LIKE :tag ORDER BY user_tags");
			$stmt->execute(array(":tag"=>'%'. $tab[$i] . ',' . '%'));

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
/* PRINT_RESULTS                                                                             */
/* ***************************************************************************************** */

function print_res($conn, $id)
{
		try
		{
			$stmt  = $conn->prepare("SELECT pseudo, birthdate FROM users 
									 INNER JOIN profils ON  users.user_id = profils.user_id 
									 WHERE users.user_id = :id");
			$stmt->execute(array(":id"=>$id));

			$row   = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt  = $conn->prepare("SELECT photo_path FROM photo 
									 WHERE photo_auteur = :id");
			$stmt->execute(array(":id"=>$id));

			$photo = $stmt->fetch(PDO::FETCH_ASSOC);
			echo '<tr id="'.$id.'">';
			if (isset($row['pseudo']))
			{
				echo '<td><section class="UserName">'.$row['pseudo'].'</section></td>'; 
				if (isset($row['birthdate']))
				{
					echo '<td><section class="UserBirthdate">'.$row['birthdate'].'</section></td>';
				}
				if (isset($photo['photo_path']))
				{
					echo '<td><img class="photo" width="150" height="150" src='.$photo['photo_path'].'/></td>';
				}
				else 
				{
					echo '<td><img class="photo" width="150" height="150" src="Image/user.png"/></td>';
				}
			}
			echo '</tr>';
		}
		catch(PDOExeption $e)
		{
			echo $e->getMessage();
		}
		$i++;
}

/*  ***************************************************************************************** */
/*	GET_USER_SEARCH_BY_ALL                                                                    */
/*  ***************************************************************************************** */


function get_search_by_all($conn, $user_id, $scoreless, $scoremore, $ageless, $agemore, $klmless, $klmmore, $tag, $orderby)
{
	try
	{
		$stmt          = $conn->prepare("SELECT * FROM users 
										 INNER JOIN profils ON users.user_id = profils.user_id 
										 WHERE users.user_id = :id");
		$stmt->execute(array(":id"=>$user_id));
		$row           = $stmt->fetch(PDO::FETCH_ASSOC);

		$tags_match    = get_user_search_by_tags($conn, $user_id, $tag);

		if ($row['user_public_long'] == NULL || $row['user_public_lat'] == NULL)
		{
			$ulong 	   = $row['user_true_long'];
			$ulat      = $row['user_true_lat'];
		}
		else
		{
			$ulong     = $row['user_public_long'];
			$ulat      = $row['user_public_lat'];
		}

		$orientation   = $row['user_sexuality'];
		$gender 	   = $row['user_gender'];

		$stmt   	   = $conn->prepare("SELECT * FROM users 
										 INNER JOIN profils ON users.user_id = profils.user_id 
										 WHERE :orientation = profils.user_gender 
										 AND :gender = profils.user_sexuality 
										 AND DEGREES(ACOS((SIN(RADIANS(:ulat)) * SIN(RADIANS(profils.user_public_lat)))+(COS(RADIANS(:ulat)) * COS(RADIANS(profils.user_public_lat)) * COS(RADIANS(:ulong - profils.user_public_long))))) * 111.13384 
										 BETWEEN :klmless AND :klmmore 
										 AND profils.user_score 
										 BETWEEN :scoreless AND :scoremore 
										 AND profils.user_id != :id 
										 AND YEAR(users.birthdate) 
										 BETWEEN :agemore AND :ageless 
										 ORDER BY ".$orderby."");
		$stmt->execute(array(":orientation"=>$orientation, ":gender"=>$gender, "ulong"=>$ulong, ":ulat"=>$ulat, ":scoreless"=>$scoreless, ":scoremore"=>$scoremore,":klmless"=>$klmless, ":klmmore"=>$klmmore, ":id"=>$user_id, ":ageless"=>$ageless, ":agemore"=>$agemore));
		$count = $stmt->rowCount();
		if ($count  == 0)
		{
			echo "No match found";
		}
		else
		{
			echo '<table id="SearchRes">';
			while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				if (in_array($row2['user_id'], $tags_match) == true && $row2['user_id'] != $row['user_id'])
				{
					print_res($conn, $row2['user_id']);
				}
			}
			echo '</table>';
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

$host = "localhost";
$name = "matcha";
$user = "root";
$pass = "";
$conn = new PDO('mysql:host='. $host.';dbname='.$name, $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['id']))
{
	$user_id 		    = $_POST['id'];
	$scoreless 		    = htmlentities($_POST['score_interval_less']);
	$scoremore 		    = htmlentities($_POST['score_interval_more']);
	$ageless   		    = age_to_birthdate(htmlentities($_POST['age_interval_less']));
	$agemore   		    = age_to_birthdate(htmlentities($_POST['age_interval_more']));
	$klmless   		    = htmlentities($_POST['klm_interval_less']);
	$klmmore   		    = htmlentities($_POST['klm_interval_more']);
	$tags 			    = htmlentities($_POST['tags']);
	$order              = htmlentities($_POST['order']);

	echo '<section class="Final_Resultats_Order">';
		get_search_by_all($conn, $user_id, $scoreless, $scoremore, $ageless, $agemore, $klmless, $klmmore, $tags, $order);
	echo '</section>';
}


?>
