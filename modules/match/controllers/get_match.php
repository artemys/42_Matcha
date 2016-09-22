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
/* GET_USER_INFOS                                                                            */
/* ***************************************************************************************** */

function get_user_infos($conn, $user_id)
{
	try
	{
		$stmt          = $conn->prepare("SELECT * FROM users 
			                             INNER JOIN profils 
			                             ON users.user_id = profils.user_id 
			                             WHERE users.user_id = :id");
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
		$age           = explode("-", $row['birthdate']);

		$orientation   = $row['user_sexuality'];
		$gender 	   = $row['user_gender'];

		$agemore       = $age[0] - 12;
		$ageless       = $age[0] + 13;

		$scoreless     = $row['user_score'] - 20;
		$scoremore     = $row['user_score'] + 20;

		$tags          = $row['user_tags'];

		$infos = array($scoremore, $scoreless, $agemore, $ageless, $ulat, $ulong, $gender, $orientation, $user_id, $tags);
		return($infos);
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */
/* GET_MATCH_BY_SCORE                                                                        */
/* ***************************************************************************************** */

function get_user_match_by_score($conn, $infos)
{
	try
	{
		$stmt = $conn->prepare("SELECT user_id FROM profils 
								WHERE :gender = user_sexuality 
								AND :sexuality = user_gender 
								AND user_score BETWEEN :scoreless AND :scoremore 
								ORDER BY user_score DESC");
		$stmt->execute(array(":scoreless"=>$infos[1], ":scoremore"=>$infos[0], ":gender"=>$infos[6], ":sexuality"=>$infos[7]));
		
		echo '<table id="Suggestions">';
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			print_res($conn, $row['user_id']);
		}
		echo '</table>';
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */
/* GET_MATCH_BY_LOC                                                                          */
/* ***************************************************************************************** */

function get_user_match_by_loc($conn, $user_id, $infos)
{
	try
	{
		$stmt     = $conn->prepare("SELECT user_id FROM profils 
									WHERE  
									DEGREES(ACOS((SIN(RADIANS(:ulat))*SIN(RADIANS(user_public_lat)))+(COS(RADIANS(:ulat))*COS(RADIANS(user_public_lat))*COS(RADIANS(:ulong - user_public_long))))) * 111.13384 
									BETWEEN :klmless AND :klmmore 
									AND user_sexuality = :gender
									AND user_gender    = :sexuality 
									AND user_id       != :id
									ORDER BY DEGREES(ACOS((SIN(RADIANS(:ulat))*SIN(RADIANS(user_public_lat)))+(COS(RADIANS(:ulat))*COS(RADIANS(user_public_lat))*COS(RADIANS(:ulong - user_public_long))))) * 111.13384");
		$stmt->execute(array(':ulong'=>$infos[5], ':ulat'=>$infos[4], ':klmless'=>0, ':klmmore'=>20, ":gender"=>$infos[6], ":sexuality"=>$infos[7], ":id"=>$infos[8]));
		$count = $stmt->rowCount();
			file_put_contents("test52.txt", $count);

		echo '<table id="Suggestions">';
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			print_res($conn, $row['user_id']);
		}
		echo '</table>';
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */
/* GET_MATCH_BY_AGE                                                                          */
/* ***************************************************************************************** */

function get_user_match_by_age($conn, $infos)
{
	try
	{
		$stmt = $conn->prepare("SELECT users.user_id FROM users 
			                    INNER JOIN profils ON users.user_id = profils.user_id 
			                    WHERE :gender = profils.user_sexuality 
			                    AND :sexuality = profils.user_gender 
			                    AND YEAR(birthdate) BETWEEN :max AND :min 
			                    ORDER BY users.birthdate");

		$stmt->execute(array(":max"=>$infos[2], ":min"=>$infos[3], ":gender"=>$infos[6], ":sexuality"=>$infos[7]));
		echo '<table id="Suggestions">';
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			print_res($conn, $row['user_id']);
		}
		echo '</table>';
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */
/* GET_MATCH_BY_TAGS                                                                         */
/* ***************************************************************************************** */

function get_user_match_by_tags($conn, $infos, $start_match)
{
	$i = 0;
	$j = 0;
	$res = array();
	$tab = explode(',', $infos[9]);

	$size = count($tab) - 1;
	try
	{
		$stmt = $conn->prepare("SELECT user_id FROM profils 
			                    WHERE user_tags LIKE :tag  
			                    AND :gender = user_sexuality 
			                    AND :sexuality = user_gender 
			                    ORDER BY user_tags DESC");
		$stmt->execute(array(":tag"=>'%'. $tab[$start_match] . ',' . '%', ":gender"=>$infos[6], ":sexuality"=>$infos[7]));

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			if ($row['user_id'] != $infos[8])
			{
				$res[$j] = $row['user_id'];
				$j++;
			}
		}
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
	if (isset($res))
	{
		return ($res);
	}
	else
	{
		return (NULL);
	}
}

/* ***************************************************************************************** */
/* GET_MATCH_BY_ALL                                                                          */
/* ***************************************************************************************** */

function get_match_by_all($conn, $user_id, $orderby, $infos)
{
	try
	{
		$i = 0;
		while (($tags_match = get_user_match_by_tags($conn, $infos, $i)) == NULL)
		{
			$i++;
		}
		$stmt   	   = $conn->prepare("SELECT * FROM users 
			                             INNER JOIN profils ON users.user_id = profils.user_id 
			                             WHERE :orientation = profils.user_gender 
			                             AND :gender = profils.user_sexuality 
			                             AND DEGREES(ACOS((SIN(RADIANS(:ulat)) * SIN(RADIANS(profils.user_public_lat)))+(COS(RADIANS(:ulat)) * COS(RADIANS(profils.user_public_lat)) * COS(RADIANS(:ulong - profils.user_public_long))))) * 111.13384 
			                             BETWEEN 0 AND 20 
			                             AND profils.user_score 
			                             BETWEEN :scoreless AND :scoremore 
			                             AND profils.user_id != :id 
			                             AND YEAR(users.birthdate) 
			                             BETWEEN :agemore AND :ageless 
			                             ORDER BY ".$orderby."");
		$stmt->execute(array(":orientation"=>$infos[7], ":gender"=>$infos[6], "ulong"=>$infos[5], ":ulat"=>$infos[4], ":scoreless"=>$infos[1], ":scoremore"=>$infos[0], ":id"=>$infos[8], ":ageless"=>$infos[3], "agemore"=>$infos[2]));
		$count         = $stmt->rowCount();
		if ($count  == 0)
		{
			echo "You have no suggestions. You can complete you're profil to have suggestions";
		}
		else
		{
			echo '<table id="Suggestions">';
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
/* GET_MATCH_BY_TYPE_OF_TRIM                                                                 */
/* ***************************************************************************************** */

function get_match_by_type($conn, $user_id, $orderby, $infos)
{
	if ($orderby == 'user_score')
	{
		get_user_match_by_score($conn, $infos);
	}
	else if ($orderby == 'birthdate')
	{
		get_user_match_by_age($conn, $infos);
	}
	else if ($orderby == 'user_public_lat')
	{
		get_user_match_by_loc($conn, $user_id, $infos);
	}
	else if ($orderby == 'user_tags')
	{
		$i = 0;
		while (($tags_match    = get_user_match_by_tags($conn, $infos, $i)) == NULL)
		{
			$i++;
		}
		$i = 0;
		while ($tags_match[$i])
		{
			print_res($conn, $tags_match[$i]);
			$i++;
		}
	}
	else
	{
		get_user_match_by_loc($conn, $user_id, $infos);
	}
}

/* ***************************************************************************************** */
/* PRINT_RESULTS                                                                             */
/* ***************************************************************************************** */

function print_res($conn, $id)
{
	try
	{

		$stmt = $conn->prepare("SELECT pseudo, birthdate FROM users INNER JOIN profils ON  users.user_id = profils.user_id WHERE users.user_id = :id");
		$stmt->execute(array(":id"=>$id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $conn->prepare("SELECT photo_path FROM photo WHERE photo_auteur = :id");
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

/* ***************************************************************************************** */

$host = "localhost";
$name = "matcha";
$user = "root";
$pass = "";
$conn = new PDO('mysql:host='. $host.';dbname='.$name, $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$orderby = htmlspecialchars($_POST['orderby']);
$type    = htmlspecialchars($_POST['type']);
$infos 	 = get_user_infos($conn, $_POST['id']);

if ($type == 'ScreenBy')
{
	get_match_by_type($conn, $_POST['id'], $orderby, $infos);
}
else
{
	get_match_by_all($conn, $_POST['id'], $orderby, $infos);
}
?>

















