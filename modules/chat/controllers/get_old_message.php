<?php


function get_old_message($conn, $r_id, $s_id)
{
	try
	{
		$stmt= $conn->prepare("SELECT * FROM chat INNER JOIN users ON users.user_id = chat.r_id  WHERE (chat.r_id = :r_id AND chat.s_id = :s_id) OR (chat.r_id = :s_id AND chat.s_id = :r_id)");
		$stmt->execute(array(":r_id"=>$r_id, ":s_id"=>$s_id));
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			if ($row['s_id'] == $s_id)
			{
				echo '<div class="Cright">';
			}
			else
			{
				echo '<div class="Cleft">';
			}
			echo '<div class="Ctime">'.$row['date'].'</div>';
			echo '<div class="Cmessage">'.$row['message'].'</div>';
			echo '</div>';
		}
	}
	catch(PDOException $e)
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

$rId = htmlentities($_POST['r_id']);
$sId = htmlentities($_POST['s_id']);
get_old_message($conn, $rId, $sId);


?>