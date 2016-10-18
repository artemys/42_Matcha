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

/* ***************************************************************************************** */
/* LIKE                                                                                      */
/* ***************************************************************************************** */
function like($user, $db, $user_id, $scored)
{
	
	$sql = "SELECT user_like FROM profils WHERE user_id = :scored";
	$array_param = array(":scored"=>$scored);
	$row = db_call($sql, $db, $array_param, 1);

	if (isset($row['user_like']))
	{
		$array = explode(',', $row['user_like']);
		if (in_array($user_id, $array))
		{
			$liked = true;
			$user->notify_entry($db, $scored, $user_id, "contected");
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
		
		$sql = "UPDATE profils SET user_like = :new_like_list, user_score = user_score + 10 WHERE user_id = :scored";
		$array_param = array(':new_like_list'=>$new_like_list, ':scored'=>$scored);
		db_call($sql, $db, $array_param, 0);

		$user->notify_entry($db, $scored, $user_id, "like");

		$sql = "SELECT user_like FROM profils WHERE user_id = :user_id";
		$array_param = array(":user_id"=>$user_id);
		$row = db_call($sql, $db, $array_param, 1);
		if (isset($row['user_like']))
		{
			$array = explode(',', $row['user_like']);
			if (in_array($scored, $array))
			{
				$liked = true;
				$user->notify_entry($db, $scored, $user_id, "contected");
			}
		}
	}
}

/* ***************************************************************************************** */
/* DISLIKE                                                                                   */
/* ***************************************************************************************** */

function dislike($user, $db, $user_id, $scored)
{

	$sql = "SELECT user_like FROM profils WHERE user_id = :scored";
	$array_param = array(":scored"=>$scored);
	$row = db_call($sql, $db, $array_param, 1);
	if (isset($row['user_like']))
	{
		$old_like_list = explode(',', $row['user_like']);
		$sql = "SELECT user_like FROM profils WHERE user_id = :user_id";
		$array_param = array(":user_id"=>$user_id);
		$row = db_call($sql, $db, $array_param, 1);
		if (isset($row['user_like']))
		{
			$array = explode(',', $row['user_like']);
			if (in_array($scored, $array))
			{
				$user->notify_entry($db, $scored, $user_id, "not contected");
			}
		}
		$array = array();
		foreach ($old_like_list as $i)
		{
			if ($user_id != $i)
			{
				array_push($array, $i);
			}
		}
		$new_like_list = implode(',', $array);
		$sql = "UPDATE profils SET user_like = :new_like_list, user_score = user_score - 10 WHERE user_id = :scored";
		$array_param = array(':new_like_list'=>$new_like_list, ':scored'=>$scored);
		db_call($sql, $db, $array_param, 0);
		$user->notify_entry($db, $scored, $user_id, "dislike");

	}
}
/* ***************************************************************************************** */
/* PRINT LIKE STATUS                                                                         */
/* ***************************************************************************************** */

function have_liked($db, $user_id)
{
	$scored  = $_GET['id'];
	$sql = "SELECT user_like FROM profils WHERE user_id = :scored";
	$array_param = array(':scored'=>$scored);
	$row = db_call($sql, $db, $array_param, 1);
	if (isset($row['user_like']))
	{
		$array = explode(',', $row['user_like']);
		if(in_array($user_id, $array))
		{
			echo '<input type="button" class="scorebtn add" onclick="send_data(\'Dislike\'); switch_btn();" value="Dislike"/>';
		}
		else
		{
			echo '<input type="button" class="scorebtn add" onclick="send_data(\'Like\'); switch_btn();" value="Like"/>';
		}
	}
	else
	{
		echo '<input type="button" class="scorebtn add" onclick="send_data(\'Like\'); switch_btn();" value="Like"/>';
	}
}
/* ***************************************************************************************** */

if (isset($_POST['score']) && isset($_GET['id']))
{
	$user = new User();
	$scored  = $_GET['id'];
	$user_id = $_SESSION['user_id'];

	if ($_POST['score'] == 'Dislike')
	{
		dislike($user, $db, $user_id, $scored);
	}	
	else if ($_POST['score'] == 'Like')
	{
		like($user, $db, $user_id, $scored);
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
