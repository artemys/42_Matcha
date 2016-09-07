<?php

if (isset($_POST['new_loc']))
{
	$host = "localhost";
   	$name = "matcha";
    $user = "root";
    $pass = "";
	$conn = new PDO('mysql:host='. $host.';dbname='.$name, $user, $pass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$new_loc = htmlentities($_POST['new_loc']);
	$country = "FR";
	try
	{
		$stmt = $conn->prepare("SELECT ville_nom_simple, ville_departement, ville_longitude_deg, ville_latitude_deg FROM villes_france_free WHERE ville_nom LIKE :new_loc");
		$stmt->execute(array(":new_loc"=>$new_loc));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($row))
		{
			$stmt = $conn->prepare("UPDATE profils SET user_public_long = :new_long, user_public_lat = :new_lat, user_public_city = :new_city, user_public_city_code = :new_city_code, user_public_country = :new_country WHERE user_id = :user_id");

			$stmt->execute(array(":new_long"=>$row['ville_longitude_deg'], 
								 ":new_lat"=>$row['ville_latitude_deg'],
							 	 ":new_city"=>$row['ville_nom_simple'],
							 	 ":new_city_code"=>$row['ville_departement'],
							 	 ":new_country"=>$country,
							 	 ":user_id"=>$_POST['user_id']));
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

?>