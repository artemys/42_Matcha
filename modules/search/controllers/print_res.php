<?php

$host = "localhost";
$name = "matcha";
$user = "root";
$pass = "";
$conn = new PDO('mysql:host='. $host.';dbname='.$name, $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

function get_user_search_by_tags($conn, $user, $tags_list)
{
	$i = 0;
	$j = 0;
	$res = array();
	$tab = explode(',', $tags_list);
	$size = count($tab) - 1;
	
	while ($i <= $size)
	{
		try
		{
			$stmt = $conn->prepare("SELECT user_id FROM profils WHERE user_tags LIKE :tag");
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

function get_user_search_by_location($conn, $user, $klmless, $klmmore)
{
	try
	{
		$user_id = $user;
		$i 		 = 0;
		
		$stmt = $conn->prepare("SELECT user_public_long, user_public_lat FROM profils WHERE user_id = :user_id");
		$stmt->execute(array(':user_id'=>$user_id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row['user_public_long'] == NULL || $row['user_public_lat'] == NULL)
		{
			$stmt = $conn->prepare("SELECT user_public_long, user_public_lat FROM profils WHERE user_id = :user_id");
			$stmt->execute(array(':user_id'=>$user_id));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		$stmt = $conn->prepare("SELECT user_id FROM profils WHERE DEGREES(ACOS((SIN(RADIANS(:ulat))*SIN(RADIANS(user_public_lat)))+(COS(RADIANS(:ulat))*COS(RADIANS(user_public_lat))*COS(RADIANS(:ulong - user_public_long))))) * 111.13384 BETWEEN :klmless AND :klmmore ORDER BY DEGREES(ACOS((SIN(RADIANS(:ulat))*SIN(RADIANS(user_public_lat)))+(COS(RADIANS(:ulat))*COS(RADIANS(user_public_lat))*COS(RADIANS(:ulong - user_public_long))))) * 111.13384");
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
			return (array("0"=>0));
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}

}
/* ***************************************************************************************** */


function get_user_search_by_score($conn, $scoreless, $scoremore)
{
	try
	{
		$res = array();
		$i = 0;

		$stmt = $conn->prepare("SELECT user_id FROM profils WHERE user_score BETWEEN :scoreless AND :scoremore ORDER BY user_score DESC");
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
			return (array("0"=>0));
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}

}

/* ***************************************************************************************** */

function get_user_search_by_age($conn, $ageless, $agemore)
{
	try
	{
		$min = age_to_birthdate($ageless);
		$max = age_to_birthdate($agemore);
		$res = array();
		$i = 0;
		$stmt = $conn->prepare("SELECT user_id FROM users WHERE YEAR(birthdate) BETWEEN :max AND :min ORDER BY birthdate");
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
			return (array("0"=>0));
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}

}
/* ***************************************************************************************** */
function array_doublon($array){
    if (!is_array($array)) 
        return false; 

    $r_valeur = Array();

    $array_unique = array_unique($array); 

    if (count($array) - count($array_unique)){ 
        for ($i=0; $i<count($array); $i++) {
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
	file_put_contents("test856.txt", "ms= ", FILE_APPEND);
	file_put_contents("test856.txt", $match_score , FILE_APPEND);
	file_put_contents("test856.txt", "\n", FILE_APPEND);

	file_put_contents("test856.txt", "ma= ", FILE_APPEND);
	file_put_contents("test856.txt", $match_age , FILE_APPEND);
	file_put_contents("test856.txt", "\n", FILE_APPEND);

	file_put_contents("test856.txt", "ml= ", FILE_APPEND);
	file_put_contents("test856.txt", $match_loc, FILE_APPEND);
	file_put_contents("test856.txt", "\n", FILE_APPEND);

	file_put_contents("test856.txt", "mt= ", FILE_APPEND);
	file_put_contents("test856.txt", $match_tag , FILE_APPEND);
	file_put_contents("test856.txt", "\n", FILE_APPEND);
	

	$best_res = array_merge($match_score, $match_age, $match_loc, $match_tag);
	file_put_contents("test856.txt", "br= ", FILE_APPEND);
	file_put_contents("test856.txt", $best_res , FILE_APPEND);
	file_put_contents("test856.txt", "\n", FILE_APPEND);
	$test = array_values($best_res);
	$test = array_doublon($test);
	$test = array_doublon($test);

	$final = get_doublons($test);
	file_put_contents("test856.txt", "fi= ", FILE_APPEND);
	file_put_contents("test856.txt", $final , FILE_APPEND);
	file_put_contents("test856.txt", "\n", FILE_APPEND);
	file_put_contents("test856.txt", "te= ", FILE_APPEND);
	file_put_contents("test856.txt", $test , FILE_APPEND);
	file_put_contents("test856.txt", "\n", FILE_APPEND);
	return ($final);
}	

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

			$stmt = $conn->prepare("SELECT pseudo, birthdate FROM users INNER JOIN profils ON  users.user_id = profils.user_id WHERE users.user_id = :id");
			$stmt->execute(array(":id"=>$tab[$i]));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt = $conn->prepare("SELECT photo_path FROM photo WHERE photo_auteur = :id");
			$stmt->execute(array(":id"=>$tab[$i]));
			$photo = $stmt->fetch(PDO::FETCH_ASSOC);
			echo 'ccaca';
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
	echo '</table>';
}
/* ***************************************************************************************** */
function get_search_by_all($conn, $user_id, $scoreless, $scoremore, $ageless, $agemore, $klmless, $klmmore, $tag, $orderby)
{
	try
	{
		$stmt          = $conn->prepare("SELECT * FROM users INNER JOIN profils ON users.user_id = profils.user_id WHERE users.user_id = :id");
		$stmt->execute(array(":id"=>$user_id));
		$row           = $stmt->fetch(PDO::FETCH_ASSOC);

		$tags_match    = get_user_search_by_tags($conn, $user_id, $row['user_tags']);

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

		$stmt   	   = $conn->prepare("SELECT * FROM users INNER JOIN profils ON users.user_id = profils.user_id WHERE :orientation = profils.user_gender AND :gender = profils.user_sexuality AND DEGREES(ACOS((SIN(RADIANS(:ulat)) * SIN(RADIANS(profils.user_public_lat)))+(COS(RADIANS(:ulat)) * COS(RADIANS(profils.user_public_lat)) * COS(RADIANS(:ulong - profils.user_public_long))))) * 111.13384 BETWEEN :klmless AND :klmmore AND profils.user_score BETWEEN :scoreless AND :scoremore AND profils.user_id != :id AND YEAR(users.birthdate) BETWEEN :agemore AND :ageless ORDER BY ".$orderby."");
		
		$stmt->execute(array(":orientation"=>$orientation, ":gender"=>$gender, "ulong"=>$ulong, ":ulat"=>$ulat, ":scoreless"=>$scoreless, ":scoremore"=>$scoremore,":klmless"=>$klmless, ":klmmore"=>$klmmore ":id"=>$user_id, ":ageless"=>$ageless, "agemore"=>$agemore));
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

if(isset($_POST['id']))
{
	$user_id 		    = $_POST['id'];
	$scoreless 		    = htmlentities($_POST['score_interval_less']);
	$scoremore 		    = htmlentities($_POST['score_interval_more']);
	$ageless   		    = htmlentities($_POST['age_interval_less']);
	$agemore   		    = htmlentities($_POST['age_interval_more']);
	$klmless   		    = htmlentities($_POST['klm_interval_less']);
	$klmmore   		    = htmlentities($_POST['klm_interval_more']);
	$tags 			    = htmlentities($_POST['selection']);

	$match_age 		    = get_user_search_by_age($conn, $ageless, $agemore);
	$match_tag 		    = get_user_search_by_tags($conn, $user_id, $tags);
	$match_loc 		    = get_user_search_by_location($conn, $user_id, $klmless, $klmmore);
	$match_score	    = get_user_search_by_score($conn, $scoreless, $scoremore);

	$best_res 			= get_multiple_user($match_score, $match_age, $match_loc, $match_tag);

	$match_scr_all 		= $match_score;
	$match_age_all 		= $match_age;
	$match_tag_all 		= $match_tag;
	$match_loc_all 		= $match_loc;

	echo '<section class="Final_Resultats_Screen">';

		print_res($best_res, $conn, "default", "block");
		
		print_res($match_scr_all,  $conn, "scr_res", "none");
		print_res($match_tag_all,  $conn, "tag_res", "none");
		print_res($match_age_all,  $conn, "age_res", "none");
		print_res($match_loc_all,  $conn, "loc_res", "none");

	echo '</section>';

	echo '<section class="Final_Resultats_Screen">';
	print_res()
	echo '</section>';

}
?>


















