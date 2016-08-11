<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   tag.c.php                                                         :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

function update_user_tags($db, $tag, $tag_owner)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT tag_id FROM tags WHERE tag_name = :tag");
		$stmt->execute(array(':tag'=>$tag));
		$useRow = $stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($useRow['tag_id']))
		{
			file_put_contents("tag_id.txt", $useRow['tag_id']);
			$tag_id = $useRow['tag_id'];
		
			$stmt = $db->conn->prepare("SELECT user_tags FROM profils WHERE user_id = (SELECT user_id FROM users WHERE  pseudo = :tag_owner)");
			$stmt->execute(array(':tag_owner'=>$tag_owner));
			$old_tag_list = $stmt->fetch(PDO::FETCH_ASSOC);

			if (isset($old_tag_list['user_tags']))
			{
				$new_tags_list = $old_tag_list['user_tags'] . $tag_id . ",";
			}
			else
			{
				$new_tags_list = $tag_id . ",";
			}
			file_put_contents("tags_list.txt", $new_tags_list);
			$stmt = $db->conn->prepare("UPDATE profils SET user_tags = :new_tags_list WHERE user_id = (SELECT user_id FROM users WHERE  pseudo = :tag_owner)");
			$stmt->execute(array(':new_tags_list'=>$new_tags_list, ':tag_owner'=>$tag_owner));
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

function save_new_tag($db, $tag)
{
	try
	{
		$stmt = $db->conn->prepare("INSERT INTO tags(tag_name) VALUES(:tag)");
		$stmt->execute(array(':tag'=>$tag));
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}


/* ***************************************************************************************** */

if (isset($_SESSION['user']))
{
	$tag_owner = $_SESSION['user']; 
	if (isset($_POST['tagbtn']))
	{
		if (isset($_POST['newtag']))
		{
			$tag = $_POST['newtag'];
			save_new_tag($db, $tag);
			update_user_tags($db, $tag, $tag_owner);
		}
		else
		{
			//error
	}	}
}
else
{
	//error
}

/* ***************************************************************************************** */

include(MODULES.'/tag/'.VIEWS.'/tag.v.php');

/* ***************************************************************************************** */
?>
