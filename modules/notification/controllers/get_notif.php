<?php

function get_notifs($conn, $id)
{
	try
	{
		$stmt = $conn->prepare("SELECT DISTINCT user_id, content, pseudo, content FROM notif INNER JOIN users ON notif.guest_id = users.user_id WHERE notif.owner_id = :id");
		$stmt->execute(array(":id"=>$id));

		echo '<table>';
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo '<tr><div>'.$row['pseudo'].' as '.$row['content'].' your profils</div></tr>';
		}
		echo '</table>';
	}
	catch(PDOException $e)
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

$id   = $_POST['id'];
get_notifs($conn, $id);
?>