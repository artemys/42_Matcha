<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   searchbar.c.php                                                  :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */


// function get_search_result($db, $search)
// {
	// try
	// {

	// 	$stmt = $db->conn->prepare("SELECT * FROM users WHERE pseudo LIKE CONCAT(:search, '%')");
	// 	$stmt->execute(array(':search'=>$search));
	// 	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	// }
	// catch(PDOException $e)
	// {
	// 	echo $e->getMessage();
	// }
// 	file_put_contents("resulte.txt", $search);

// 	// return("<div id='Result'>" . $row['pseudo'] . "</div>");
// 	$_SESSION['res'] = "<div id='Result'>" . $row['pseudo'] . "</div>";
// 	file_put_contents("gt.txt", $_SESSION['res']);
// }


// if (isset($_POST['data']))
// {

// 	$search = htmlentities($_POST['data']);
// 	echo get_search_result($db, $search);
// }
// if($_POST)
// {
//     $q = mysqli_real_escape_string($conn,$_POST['search']);
//     $strSQL_Result = mysqli_query($conn ,"select pseudo from users where pseudo like '%$q%' or email like '%$q%' order by id LIMIT 5");
//     while($row=mysqli_fetch_array($strSQL_Result))
//     {
//         $username   = $row['pseudo'];
//         $b_username = '<strong>'.$q.'</strong>';
//         $final_username = str_ireplace($q, $b_username, $username);

//     }
// }

// function get_search_result($db)
// {

	if (isset($_GET['term']))
	{
		
		$search = $_GET['term'];
		file_put_contents("omswg.txt", $search, FILE_APPEND);

		$stmt = $db->conn->prepare("SELECT * FROM users WHERE pseudo LIKE '%:search%'");
		$stmt->execute(array(':search' => $search));
		$array = array();
		$donnee = $stmt->fetch(PDO::FETCH_ASSOC);
		file_put_contents("omswgoo.txt", $donnee['pseudo'], FILE_APPEND);
		
	    // array_push($array, $donnee['pseudo']); 

	// while($donnee = $stmt->fetch()) 
	// {
	//     array_push($array, $donnee['pseudo']); 
		// file_put_contents("omswgoo.txt", $donnee['pseudo'], FILE_APPEND);

	// }
	// }
	// echo json_encode($array);
	}


 //    $key=$_GET['key'];
 //    $array = array();
	// $stmt = $db->conn->prepare("SELECT * FROM users WHERE pseudo LIKE '%{$key}%'");
	
 //    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
 //    {
 //      $array[] = $row['pseudo'];
 //    }
 //    echo json_encode($array);


/* ***************************************************************************************** */

include(MODULES.'/searchbar/'.VIEWS.'/searchbar.v.php');

/* ***************************************************************************************** */

?>