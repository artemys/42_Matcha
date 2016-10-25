<?php
/* ***************************************************************************************** */
/* DB_CONNECTION                                                                             */
/* ***************************************************************************************** */

$host = "localhost";
$name = "matcha";
$user = "root";
$pass = "";
$conn = new PDO('mysql:host='. $host.';dbname='.$name, $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/* ***************************************************************************************** */
/* GET_USER_INFOS                                                                            */
/* ***************************************************************************************** */

function get_user_gender_and_sexuality($conn, $id)
{
	try
	{
		$stmt = $conn->prepare("SELECT user_gender, user_sexuality FROM profils 
								WHERE user_id = :id");
		$stmt->execute(array(":id"=>$id));

	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$res = array($row['user_gender'], $row['user_sexuality']);
		return ($res);
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}

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
/* GET_USER_SEARCH_BY_TAGS                                                                   */
/* ***************************************************************************************** */

function get_user_search_by_tag($conn, $user, $tags_list, $gender, $sexuality)
{
	$tags_list = explode(',', $tags_list);
	$s = count($tags_list);
	$i = 0;
	$res = array();
	while ($s < 5)
	{
		$tags_list[$s] = 0;
		$s++;
	}
	try
	{
		$stmt = $conn->prepare("SELECT Distinct tagsasso.user_id FROM tagsasso INNER JOIN profils ON profils.user_id = tagsasso.user_id WHERE tagsasso.tag_id IN (:id1, :id2, :id3, :id4, :id5) AND profils.user_sexuality = :gender AND profils.user_gender = :sexuality AND tagsasso.user_id NOT IN (SELECT bloc_id FROM blocsignal WHERE user_id = :id AND type = 'bloc')");
		$stmt->execute(array(":id1"=>$tags_list[0],":id2"=>$tags_list[1],":id3"=>$tags_list[2],":id4"=>$tags_list[3],":id5"=>$tags_list[4], ":sexuality"=>$sexuality, ":gender"=>$gender));

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$res[$i] = $row['user_id'];
			$i++;
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
	return ($res);
}

/* ***************************************************************************************** */
/* GET_USER_SEARCH_BY_LOCATION                                                               */
/* ***************************************************************************************** */

function get_user_search_by_loc($conn, $user, $klmless, $klmmore, $gender, $sexuality)
{
	if ($klmless != null || $klmmore != null)
	{
		try
		{
			$user_id  = $user;
			$i 		  = 0;
			
			$stmt     = $conn->prepare("SELECT user_public_long, user_public_lat FROM profils 
										WHERE user_id = :user_id");
			$stmt->execute(array(':user_id'=>$user_id));
			$row      = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($row['user_public_long'] == NULL || $row['user_public_lat'] == NULL)
			{
				$stmt = $conn->prepare("SELECT user_public_long, user_public_lat FROM profils 
										WHERE user_id = :user_id");
				$stmt->execute(array(':user_id'=>$user_id));
				$row  = $stmt->fetch(PDO::FETCH_ASSOC);
				$lat_status = "user_public_lat";
				$long_status = "user_public_long";
			}
			$lat_status = "user_true_lat";
			$long_status = "user_true_long";
			$stmt     = $conn->prepare("SELECT user_id FROM profils WHERE (DEGREES(ACOS((SIN(RADIANS(:ulat))*SIN(RADIANS(user_public_lat)))+(COS(RADIANS(:ulat))*COS(RADIANS(user_public_lat))*COS(RADIANS(:ulong - user_public_long))))) * 111.13384 BETWEEN :klmless AND :klmmore OR DEGREES(ACOS((SIN(RADIANS(:ulat))*SIN(RADIANS(user_true_lat)))+(COS(RADIANS(:ulat))*COS(RADIANS(user_true_lat))*COS(RADIANS(:ulong - user_true_long))))) * 111.13384 BETWEEN :klmless AND :klmmore) AND user_sexuality = :gender AND user_gender = :sexuality AND user_id NOT IN (SELECT bloc_id FROM blocsignal WHERE user_id = :id AND type = 'bloc') ORDER BY DEGREES(ACOS((SIN(RADIANS(:ulat))*SIN(RADIANS(".$lat_status.")))+(COS(RADIANS(:ulat))*COS(RADIANS(".$lat_status."))*COS(RADIANS(:ulong - ".$long_status."))))) * 111.13384");
			$stmt->execute(array(':ulong'=>$row['user_public_long'], ':ulat'=>$row['user_public_lat'], ':klmless'=>$klmless, ':klmmore'=>$klmmore, ":gender"=>$gender, ":sexuality"=>$sexuality));
			$count = $stmt->rowCount();
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
				return (array("0"=>0));
			}
		}
		catch(PDOExeption $e)
		{
			echo $e->getMessage();
		}
	}
}

/* ***************************************************************************************** */
/* GET_USER_SEARCH_BY_SCORE                                                                  */
/* ***************************************************************************************** */

function get_user_search_by_scr($conn, $scoreless, $scoremore, $gender, $sexuality)
{
	try
	{
		$res  = array();
		$i    = 0;
		$stmt = $conn->prepare("SELECT user_id FROM profils 
								WHERE :gender = user_sexuality 
								AND :sexuality = user_gender
								AND user_id NOT IN (SELECT bloc_id FROM blocsignal WHERE user_id = :id AND type = 'bloc')
								AND user_score BETWEEN :scoreless AND :scoremore
								ORDER BY user_score DESC");
		$stmt->execute(array(":scoreless"=>$scoreless, ":scoremore"=>$scoremore, ":gender"=>$gender, ":sexuality"=>$sexuality));
		
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
			return (array("0"=>0));
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */
/* GET_USER_SEARCH_BY_AGE                                                                    */
/* ***************************************************************************************** */

function get_user_search_by_age($conn, $ageless, $agemore, $gender, $sexuality)
{
	try
	{
		$min = age_to_birthdate($ageless);
		$max = age_to_birthdate($agemore);
		$res = array();
		$i = 0;
		$stmt = $conn->prepare("SELECT users.user_id FROM users 
								INNER JOIN profils ON users.user_id = profils.user_id 
								WHERE :gender = profils.user_sexuality
								AND :sexuality = profils.user_gender
								AND user_id NOT IN (SELECT bloc_id FROM blocsignal WHERE user_id = :id AND type = 'bloc')
								AND YEAR(birthdate) BETWEEN :max AND :min ORDER BY users.birthdate");
		$stmt->execute(array(":max"=>$max, ":min"=>$min, ":gender"=>$gender, ":sexuality"=>$sexuality));
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
			return (array("0"=>0));
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}
/* ***************************************************************************************** */
/* TRIM_FINAL_RESULT                                                                         */
/* ***************************************************************************************** */

function array_doublon($array){
    if (!is_array($array)) 
        return false; 

    $r_valeur = Array();

    $array_unique = array_unique($array); 

    if (count($array) - count($array_unique)){ 
        for ($i= 0; $i < count($array); $i++) {
            if (!array_key_exists($i, $array_unique)) 
                $r_valeur[] = $array[$i];
        } 
    } 
    return $r_valeur;
}

/* ***************************************************************************************** */

function get_doublons($test)
{
	$i = 0;
	$j = 0;
	$doublons = Array();

	while ($i <= count($test))
	{
		$tmp = $test[0];
		$array = array_shift($test);
		if (in_array($tmp, $test) && !in_array($tmp, $doublons))
		{
			$doublons[$j] = $tmp;
			$j++;
		}
		$i++;
	}
	return ($doublons);
}

/* ***************************************************************************************** */

function get_multiple_user($match_score, $match_age, $match_loc, $match_tag)
{
	$best_res = array_merge($match_score, $match_age, $match_loc, $match_tag);
	$test     = array_values($best_res);
	$test     = array_doublon($test);
	$test     = array_doublon($test);
	$final    = get_doublons($test);

	return ($final);
}	

/* ***************************************************************************************** */
/*	PRINT_RESULT                                                                             */
/* ***************************************************************************************** */
function print_res($tab, $conn, $id, $display_state)
{
	$i = 0;
	$size = count($tab) - 1;
	echo '<table id="'.$id.'" style="display:'.$display_state.'">';
	while ($i <= $size)
	{
		try
		{
			$stmt = $conn->prepare("SELECT pseudo, birthdate FROM users
			                        INNER JOIN profils ON users.user_id = profils.user_id 
			                        WHERE users.user_id = :id");
			$stmt->execute(array(":id"=>$tab[$i]));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt = $conn->prepare("SELECT photo_path FROM photo WHERE photo_auteur = :id");
			$stmt->execute(array(":id"=>$tab[$i]));
			$photo = $stmt->fetch(PDO::FETCH_ASSOC);
			echo '<tr>';
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
	if ( $i == 0)
	{
		// echo 'No match Found.';
	}
	echo '</table>';
}
/* ***************************************************************************************** */

if(isset($_POST['id']))
{
	$user_id 		    = $_POST['id'];

	$infos 				= get_user_gender_and_sexuality($conn, $user_id);

	$gender 			= $infos[0];
	$sexuality 			= $infos[1];

	$scoreless 		    = htmlentities($_POST['score_interval_less']);
	$scoremore 		    = htmlentities($_POST['score_interval_more']);
	$ageless   		    = htmlentities($_POST['age_interval_less']);
	$agemore   		    = htmlentities($_POST['age_interval_more']);
	$klmless   		    = htmlentities($_POST['klm_interval_less']);
	$klmmore   		    = htmlentities($_POST['klm_interval_more']);
	$tags 			    = htmlentities($_POST['tags']);

	$match_loc 		    = get_user_search_by_loc($conn, $user_id,   $klmless, $klmmore, $gender, $sexuality);
	$match_tag 		    = get_user_search_by_tag($conn, $user_id,   $tags,     $gender, $sexuality);
	$match_age 		    = get_user_search_by_age($conn, $ageless,   $agemore,   $gender, $sexuality);
	$match_score	    = get_user_search_by_scr($conn, $scoreless, $scoremore, $gender, $sexuality);
	$best_res 			= get_multiple_user($match_score, $match_age, $match_loc, $match_tag);


	echo '<section class="Final_Resultats_Screen">';
		print_res($best_res, $conn, "default", "block");
		
		print_res($match_score,  $conn, "scr_res", "none");
		print_res($match_tag,  $conn, "tag_res", "none");
		print_res($match_age,  $conn, "age_res", "none");
		print_res($match_loc,  $conn, "loc_res", "none");
	echo '</section>';
}
?>

















