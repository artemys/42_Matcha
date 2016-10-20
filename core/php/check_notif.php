<?php
function get_new_notif($conn, $id)
{
	try
	{
		$stmt = $conn->prepare("SELECT * FROM notif INNER JOIN users ON notif.guest_id = users.user_id WHERE notif.owner_id = :id AND notif.seen = 1");
		$stmt->execute(array(":id"=>$id));
		$data = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			array_push($data, $row['content']);
			array_push($data, $row['pseudo']);
			array_push($data, $row['owner_id']);
			array_push($data, $row['notif_id']);
		}
		print json_encode($data);
		$stmt = $conn->prepare("UPDATE notif SET seen = 0 WHERE notif_id = :id");
		$stmt->execute(array(":id"=>$data[3]));
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
get_new_notif($conn, $id);
?>