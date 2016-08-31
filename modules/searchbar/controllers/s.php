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
	        // $stmt = $conn->prepare("SELECT * FROM users");
	        if ($search_keyword != "")
	        {
		        $stmt = $conn->prepare("SELECT tag_name FROM tags WHERE tag_name LIKE :search_keyword");
				$stmt->execute(array(':search_keyword'=>$search_keyword . '%'));
				// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			
		        // file_put_contents("test85.txt", "i= " . $row['tag_name'] . " ", FILE_APPEND);
		        file_put_contents("test85.txt", "j= " . $search_keyword . " ", FILE_APPEND);
		        if ($stmt->rowCount() > 0)
		        {
		        	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		        	{
						if ($row['tag_name'])
						{
		        			echo '<div class="resultats">'. $row['tag_name'] . '</div>';
						}
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
				 		
	 //        while()
	 //        {
	 //            echo '<div>'.$row['tag_name'].'</div>';
	 //        }
	 //        if (!$row || $row['tag_name'] == "")
	 //        {
  //     			
  //     		}

	 //    }
   
    }	


   ?>