<?php

function notify_entry($db, $owner_id, $guest_id, $content)
{
	try
	{
		$stmt = $db->prepare("INSERT INTO notif(owner_id, guest_id, content, seen) VALUES(:owner_id, :guest_id, :content, :seen)");
		$stmt->execute(array(":owner_id"=>$owner_id, ":guest_id"=>$guest_id, ":content"=>$content, ":seen"=>1));
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

function save_message($conn, $rId, $sId, $content)
{
	try
	{
		$stmt = $conn->prepare("INSERT INTO chat(r_id, s_id, message) VALUES(:rId, :sId, :content)");
		$stmt->execute(array(":sId"=>$sId, ":rId"=>$rId, ":content"=>$content));
		notify_entry($conn, $rId, $sId, "message");
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
$content = htmlentities($_POST['message']);
save_message($conn, $rId, $sId, $content);
?>