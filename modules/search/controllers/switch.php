<?php

$host = "localhost";
$name = "matcha";
$user = "root";
$pass = "";
$conn = new PDO('mysql:host='. $host.';dbname='.$name, $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function print_res($tab, $conn)
{
	$i = 0;
	$size = count($tab) - 1;
	echo '<section class="Final_Resultats"><table>';
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

			echo '<tr>';
			if (isset($row['pseudo']))
			{
				echo '<td><section class="UserName">'.$row['pseudo'].'</section></td>'; 
			}
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
			echo '</tr>';
		}
		catch(PDOExeption $e)
		{
			echo $e->getMessage();
		}
		if ($i % 2 == 0)
		{
			echo '</br>';
		}
		$i++;
	}
	echo '</table></section>';
}
if ($_POST['res'] == 'scr')
{
	$best_res = array_merge($match_score, $best_res);
}
else if ($_POST['res'] == 'loc')
{
	$best_res = array_merge($match_loc, $best_res);
}
else if ($_POST['res'] == 'age')
{
	$best_res = array_merge($match_age, $best_res);
}
else if ($_POST['res'] == 'tag')
{
	$best_res = array_merge($match_tag, $best_res);
}
print_res($best_res, $conn);

?>