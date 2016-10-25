<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
    if(isset($_POST['str']))
    {
    	$host = "localhost";
   		$name = "matcha";
    	$user = "root";
    	$pass = "";
		$conn = new PDO('mysql:host='. $host.';dbname='.$name, $user, $pass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $search_keyword = $_POST['str'];
        $i = 0;
        if ($search_keyword != "")
        {
	        $stmt = $conn->prepare("SELECT ville_nom, ville_departement FROM villes_france_free WHERE ville_nom LIKE :search_keyword LIMIT 8");
			$stmt->execute(array(':search_keyword'=>$search_keyword . '%'));
	        if ($stmt->rowCount() > 0)
	        {
	        	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	        	{
					if ($row['ville_nom'])
					{
	        			echo '<input readonly type="select" value="'.$row["ville_nom"]." ".$row["ville_departement"].'" id="'.$i.'" class="resultats"  onfocus="this.select();"  onBlur="setId(this.id)" onclick="this.select();" />';
                        $i++;
					}
	        	}
                echo '<button  id="choose" onclick="send_data()">selectionner</button>';
	           
    		}
    		else
	    	{
        		echo '<div>No matching records.</div>';
        	}
        }
       	else
        {
        		echo '<div>No matching records.</div>';
        }
    }	
?>