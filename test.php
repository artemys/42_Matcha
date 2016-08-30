<?php
// function get_search_result($db, $search)
// {
		
		$search = $_GET['term'];
		$stmt = $db->conn->prepare("SELECT * FROM users");
		// $stmt->execute(array(':search' => '%'.$search.'%'));
		$array = array();
	while($donnee = $stmt->fetch()) 
	{
		file_put_contents("derniertestavantlesuicide.txt", $donnee['pseudo'], FILE_APPEND);
	    array_push($array, $donnee['pseudo']); 
	}
	echo json_encode($array);


?>