<?php

function bloc_user($conn, $user_id, $owner_id, $type)
{
	try
	{
		$stmt = $conn->prepare("INSERT INTO blocsignal(bloc_id, user_id, type) VALUES(:owner_id, :user_id, :type)");
		$stmt->execute(array(":user_id"=>$user_id, ":owner_id"=>$owner_id, ":type"=>$type));
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

$user_id = htmlentities($_POST['user_id']);
$owner_id = htmlentities($_POST['owner_id']);
$type = htmlentities($_POST['type']);
bloc_user($conn, $user_id, $owner_id, $type);

?>