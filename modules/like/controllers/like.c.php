<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   like.c.php                                                        :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

function like($db, $user_id, $scored)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT user_like FROM profils WHERE user_id = :scored");
		$stmt->execute(array(':scored'=>$scored));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($row['user_like']))
		{
			$array = explode(',', $row['user_like']);
			foreach ($array as $i) 
			{
				if ($i == $user_id)
				{
					$liked = true;
				}
			}
		}
		else
		{
			$array = array();
		}
		if (!$liked)
		{
			array_push($array, $user_id);
			$new_like_list = implode(',', $array);
			$stmt = $db->conn->prepare("UPDATE profils SET user_like = :new_like_list WHERE user_id = :scored");
			$stmt->execute(array(':new_like_list'=>$new_like_list, ':scored'=>$scored));
			$stmt = $db->conn->prepare("UPDATE profils SET user_score = user_score + 10 WHERE user_id = :scored");
			$stmt->execute(array(':scored'=>$scored));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			file_put_contents("test1236", $scored);
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

function dislike($db, $user_id, $scored)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT user_like FROM profils WHERE user_id = :scored");
		$stmt->execute(array(':scored'=>$scored));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($row['user_like']))
		{
			$old_like_list = explode(',', $row['user_like']);
			$array = array();
			foreach ($old_like_list as $i)
			{
				if ($user_id != $i)
				{
					array_push($array, $i);
				}
			}
			$new_like_list = implode(',', $array);
			$stmt = $db->conn->prepare("UPDATE profils SET user_like = :new_like_list WHERE user_id = :scored");
			$stmt->execute(array(':new_like_list'=>$new_like_list, ':scored'=>$scored));
			$stmt = $db->conn->prepare("UPDATE profils SET user_score = user_score - 10 WHERE user_id = :scored");
			$stmt->execute(array(':scored'=>$scored));
		}
		else
		{
			//error
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}
/* ***************************************************************************************** */

function have_liked($db, $user_id)
{
	try
	{
		$scored  = $_GET['id'];
		$stmt = $db->conn->prepare("SELECT user_like FROM profils WHERE user_id = :scored");
		$stmt->execute(array(':scored'=>$scored));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if (isset($row['user_like']))
		{
			$array = explode(',', $row['user_like']);
			$liked = false;
			foreach ($array as $i) 
			{
				if ($i == $user_id)
				{
					$liked = true;
				}
			}
			if ($liked)
			{
				echo '<input type="button" class="scorebtn" onclick="send_data(\'Dislike\'); switch_btn();" value="Dislike"/>';
			}
			else
			{
				echo '<input type="button" class="scorebtn" onclick="send_data(\'Like\'); switch_btn();" value="Like"/>';
			}
		}
		else
		{
			echo '<input type="button" class="scorebtn" onclick="send_data(\'Like\'); switch_btn();" value="Like"/>';
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}

}
/* ***************************************************************************************** */



if (isset($_POST['score']) && isset($_GET['id']))
{
	$scored  = $_GET['id'];
	$user_id = $_SESSION['user_id'];

	if ($_POST['score'] == 'Dislike')
	{
		dislike($db, $user_id, $scored);
	}	
	else if ($_POST['score'] == 'Like')
	{
		like($db, $user_id, $scored);

	}
	else
	{
		//error
	}
}
else
{
	//error
}

/* ***************************************************************************************** */

include(MODULES.'/like/'.VIEWS.'/like.v.php');

/* ***************************************************************************************** */
?>
