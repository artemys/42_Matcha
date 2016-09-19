<?php
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


function get_user_match_by_tags($conn, $user_id, $tags_list, $start_match)
{
	$i = 0;
	$j = 0;
	$res = array();
	$tab = explode(',', $tags_list);
	$size = count($tab) - 1;
	try
	{
		$stmt = $conn->prepare("SELECT user_id FROM profils WHERE user_tags LIKE :tag ORDER BY user_tags DESC");
		$stmt->execute(array(":tag"=>'%'. $tab[$start_match] . ',' . '%'));

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			if ($row['user_id'] != $user_id)
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
		return (array(0));
	}
}
/* ***************************************************************************************** */

function age_to_birthdate($age)
{
	$now = explode('/', date('d/m/Y'));
	return($now[2] - $age);
}
/* ***************************************************************************************** */

function get_match($conn, $user_id, $orderby)
{
	try
	{
		$stmt          = $conn->prepare("SELECT * FROM users INNER JOIN profils ON users.user_id = profils.user_id WHERE users.user_id = :id");
		$stmt->execute(array(":id"=>$user_id));
		$row           = $stmt->fetch(PDO::FETCH_ASSOC);
		$i = 0;
		while (($tags_match    = get_user_match_by_tags($conn, $user_id, $row['user_tags'], $i)) == NULL)
		{
			$i++;
		}

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

		$stmt   	   = $conn->prepare("SELECT * FROM users INNER JOIN profils ON users.user_id = profils.user_id WHERE :orientation = profils.user_gender AND :gender = profils.user_sexuality AND DEGREES(ACOS((SIN(RADIANS(:ulat)) * SIN(RADIANS(profils.user_public_lat)))+(COS(RADIANS(:ulat)) * COS(RADIANS(profils.user_public_lat)) * COS(RADIANS(:ulong - profils.user_public_long))))) * 111.13384 BETWEEN 0 AND 20 AND profils.user_score BETWEEN :scoreless AND :scoremore AND profils.user_id != :id AND YEAR(users.birthdate) BETWEEN :agemore AND :ageless ORDER BY ".$orderby."");
		
		$stmt->execute(array(":orientation"=>$orientation, ":gender"=>$gender, "ulong"=>$ulong, ":ulat"=>$ulat, ":scoreless"=>$scoreless, ":scoremore"=>$scoremore, ":id"=>$user_id, ":ageless"=>$ageless, "agemore"=>$agemore));
		$count = $stmt->rowCount();
		// echo $count;
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

$host = "localhost";
$name = "matcha";
$user = "root";
$pass = "";
$conn = new PDO('mysql:host='. $host.';dbname='.$name, $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$orderby = htmlspecialchars($_POST['orderby']);
get_match($conn, $_POST['id'], $orderby);
?>