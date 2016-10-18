<?php

function db_call($sql, $db, $array_param, $row)
{
	try
	{
		$stmt = $db->prepare($sql);
		$stmt->execute($array_param);
		if ($row == 1)
		{
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		return($row);
	}
	catch(PDOExeption $e)
	{
		echo $e->getMessage();
	}
}

function get_user_score($id, $db)
{

	
	$sql = "SELECT user_score from profils where user_id = :id";
	$array_param = array(':id'=>$id);
	$row = db_call($sql, $db, $array_param, 1);
	echo $row['user_score'];
}

$host = "localhost";
$name = "matcha";
$user = "root";
$pass = "";
$conn = new PDO('mysql:host='. $host.';dbname='.$name, $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = htmlentities($_POST['id']);
get_user_score($id, $conn);

?>