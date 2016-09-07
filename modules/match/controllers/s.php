<?php

	if(isset($_POST['str']))
	{
		$host = "localhost";
		$name = "matcha";
		$user = "root";
		$pass = "";
		$conn = new PDO('mysql:host='. $host.';dbname='.$name, $user, $pass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    $search_keyword = $_POST['str'];
	    $user_id = $_POST['user_id'];
		$i = 0;

	    if ($search_keyword != "")
	    {
	        $stmt = $conn->prepare("SELECT user_id, pseudo FROM users WHERE pseudo LIKE :search_keyword");
			$stmt->execute(array(':search_keyword'=>$search_keyword . '%'));
		
	        if ($stmt->rowCount() > 0)
	        {
	        	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	        	{
					if ($row && $row['user_id'] != $user_id)
					{
        				echo '<input readonly type="select" value="'.$row["pseudo"].'" id="'.$i.'" class="resultats" onclick="go_toprofils('.$row['user_id'].')"/>';
        				$i++;
        			}
	        	}
	        	if ($i > 0)
	        	{
	        		echo '<button  id="choose">selectionner</button>';
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
	   	else
	    {
	    		echo '<div>No matching records.</div>';
	    }
	}	
?>

<!-- onclick="(window.location='?nav=Signin')" -->