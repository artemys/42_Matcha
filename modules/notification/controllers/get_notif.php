<?php


function get_old_notifs($conn, $id)
{
	try
	{
		$stmt = $conn->prepare("SELECT user_id, content, pseudo, notif_id FROM notif INNER JOIN users ON notif.guest_id = users.user_id WHERE notif.owner_id = :id AND notif.seen = 0");
		$stmt->execute(array(":id"=>$id));
		$i = 0;
		echo '<table>';
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo '<tr>
					<div class="note" id='.$row['notif_id'].' onclick="this.remove(); delete_history(this.id);">'.$row['pseudo'].' as '.$row['content'].' your profils</div>
				</tr>';
			$i++;
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
get_old_notifs($conn, $id);

?>