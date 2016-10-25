<?php

function delete_notifs($conn, $id)
{
	try
	{
		$stmt = $conn->prepare("DELETE FROM notif WHERE notif_id = :id");
		$stmt->execute(array(":id"=>$id));
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
delete_notifs($conn, $id);
?>