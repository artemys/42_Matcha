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

// function get_user_search_by_tags($conn, $user, $tags_list)
// {
// 	$s = count($tags_list);
// 	if ($s > 1)
// 	{
// 		$tags_list = explode(',', $tags_list);
// 	}
// 	echo $tags_list;
// 	$i = 0;
// 	$res = array();
// 	while ($s < 5)
// 	{
// 		$tags_list[$s] = 0;
// 		echo $tags_list[$s];

// 		$s++;
// 	}
// 	try
// 	{
// 		$stmt = $conn->prepare("SELECT user_id FROM tagsasso WHERE tag_id IN (:id1, :id2, :id3, :id4, :id5)");
// 		$stmt->execute(array(":id1"=>$tags_list[0],":id2"=>$tags_list[1],":id3"=>$tags_list[2],":id4"=>$tags_list[3],":id5"=>$tags_list[4]));

// 		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
// 		{
// 			$res[$i] = $row['user_id'];
// 			$i++;
// 		}
// 	}
// 	catch(PDOExeption $e)
// 	{
// 		echo $e->getMessage();
// 	}
// 	return ($res);
// }

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
		$stmt          = $conn->prepare("SELECT * FROM users INNER JOIN profils ON users.user_id = profils.user_id WHERE users.user_id = :id");
		$stmt->execute(array(":id"=>$user_id));
		$row           = $stmt->fetch(PDO::FETCH_ASSOC);

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

		$sqlStart = "SELECT DISTINCT users.user_id, users.birthdate, profils.user_true_lat, profils.user_public_lat, profils.user_tags, profils.user_score FROM users INNER JOIN profils ON users.user_id = profils.user_id INNER JOIN tagsAsso ON users.user_id = tagsAsso.user_id WHERE profils.user_gender = :orientation AND profils.user_sexuality = :gender";
		$param = array(":orientation"=>$orientation, ":gender"=>$gender, ":id"=>$user_id);
		if ($orderby == "")
		{
			$orderby = 'user_true_lat';
		}
		if ($scoreless != "" && $scoremore != "")
		{
			$sqlScr = " AND profils.user_score BETWEEN :scoreless AND :scoremore";
			$sqlStart = $sqlStart . $sqlScr;
			$paramScr =  array(":scoreless"=>$scoreless, ":scoremore"=>$scoremore);
			$param = array_merge($param, $paramScr);
		}
		if ($ageless != "" && $agemore != "")
		{
			$ageless = age_to_birthdate($ageless);
			$agemore = age_to_birthdate($agemore);
			$sqlAge = " AND YEAR(users.birthdate) BETWEEN :agemore AND :ageless";
			$sqlStart = $sqlStart . $sqlAge;
			$paramAge = array(":ageless"=>$ageless, ":agemore"=>$agemore);
			$param = array_merge($param, $paramAge);
		}
		if ($klmless != "" && $klmmore != "")
		{
			$sqlLoc = " AND ((DEGREES(ACOS((SIN(RADIANS(:ulat)) * SIN(RADIANS(profils.user_public_lat)))+(COS(RADIANS(:ulat)) * COS(RADIANS(profils.user_public_lat)) * COS(RADIANS(:ulong - profils.user_public_long))))) * 111.13384 BETWEEN :klmless AND :klmmore) OR (DEGREES(ACOS((SIN(RADIANS(:ulat)) * SIN(RADIANS(profils.user_true_lat)))+(COS(RADIANS(:ulat)) * COS(RADIANS(profils.user_true_lat)) * COS(RADIANS(:ulong - profils.user_true_long))))) * 111.13384 BETWEEN :klmless AND :klmmore))";
			$sqlStart = $sqlStart . $sqlLoc;
			$paramLoc = array("ulong"=>$ulong, ":ulat"=>$ulat ,":klmless"=>$klmless, ":klmmore"=>$klmmore);
			$param = array_merge($param, $paramLoc);
		}
		if ($tag != "")
		{
			$s = count($tag);
			if ($s > 1)
			{
				$tag = explode(',', $tag);
			}
			while ($s < 5)
			{
				$tag[$s] = 0;
				$s++;
			}
			$sqlTag = " AND tagsAsso.tag_id IN (:id1, :id2, :id3, :id4, :id5)";
			$paramTag = array(":id1"=>$tag[0],":id2"=>$tag[1],":id3"=>$tag[2],":id4"=>$tag[3],":id5"=>$tag[4]);
			echo $paramTag[0];
		}
		$sqlEnd = "AND profils.user_id NOT IN (SELECT bloc_id FROM blocsignal WHERE user_id = :id AND type = 'bloc') AND profils.user_id != :id ORDER BY ".$orderby."";
		$sqlStart = $sqlStart . $sqlEnd;
		$stmt   	   = $conn->prepare($sqlStart);
		$stmt->execute($param);
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
				print_res($conn, $row2['user_id']);
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
	$ageless   		    = htmlentities($_POST['age_interval_less']);
	$agemore   		    = htmlentities($_POST['age_interval_more']);
	$klmless   		    = htmlentities($_POST['klm_interval_less']);
	$klmmore   		    = htmlentities($_POST['klm_interval_more']);
	$tags 			    = htmlentities($_POST['tags']);
	$order              = htmlentities($_POST['order']);

	echo '<section class="Final_Resultats_Order">';
		get_search_by_all($conn, $user_id, $scoreless, $scoremore, $ageless, $agemore, $klmless, $klmmore, $tags, $order);
	echo '</section>';

}


?>
