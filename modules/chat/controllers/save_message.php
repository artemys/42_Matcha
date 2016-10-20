<?php

function save_message($conn, $rId, $sId, $content)
{
	try
	{
		$stmt = $conn->prepare("INSERT INTO chat(r_id, s_id, message) VALUES(:rId, :sId, :content)");
		$stmt->execute(array(":sId"=>$sId, ":rId"=>$rId, ":content"=>$content));
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
		file_put_contents("test51.txt", $e->getMessage(), FILE_APPEND);
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
$content = htmlentities($_POST['message']);
save_message($conn, $rId, $sId, $content);
?>