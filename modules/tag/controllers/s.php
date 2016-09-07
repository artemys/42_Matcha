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
		$i = 0;

	    if ($search_keyword != "")
	    {
	        $stmt = $conn->prepare("SELECT tag_name FROM tags WHERE tag_name LIKE :search_keyword");
			$stmt->execute(array(':search_keyword'=>$search_keyword . '%'));
		
	        if ($stmt->rowCount() > 0)
	        {
	        	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	        	{
	        		if (isset($_POST['array']))
	        		{
	        			$tag_list = $_POST['array'];
						$tab = explode(",", $tag_list);
						if ($row['tag_name'] && !in_array($row['tag_name'], $tab))
						{
	        				echo '<input readonly type="select" value="'.$row["tag_name"].'" id="'.$i.'" class="resultats" 	onfocus="this.select();"  onBlur="setId(this.id)" onclick="this.select();" />';
	        				$i++;
	        			}
					}
	        	}
	        	if ($i > 0)
	        	{
	        		echo '<button name="selecttag"  id="choose" onclick="send_data()">selectionner</button>';
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