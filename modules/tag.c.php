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
			$tag_id = $useRow['tag_id'];
		
			$stmt = $db->conn->prepare("SELECT user_tags FROM profils WHERE user_id = (SELECT user_id FROM users WHERE  pseudo = :tag_owner)");
			$stmt->execute(array(':tag_owner'=>$tag_owner));
			$old_tag_list = $stmt->fetch(PDO::FETCH_ASSOC);

			if (strstr($old_tag_list['user_tags'], $tag_id) == false)
			{
				if (isset($old_tag_list['user_tags']))
				{
					$new_tags_list = $old_tag_list['user_tags'] . $tag_id . ",";
				}
				else
				{
					$new_tags_list = $tag_id . ",";
				}
					$tmp = explode(",", $new_tags_list);
					arsort($tmp);
					$new_tags_list = implode(',', $tmp);
				$stmt = $db->conn->prepare("UPDATE profils SET user_tags = :new_tags_list WHERE user_id = (SELECT user_id FROM users WHERE  pseudo = :tag_owner)");
				$stmt->execute(array(':new_tags_list'=>$new_tags_list, ':tag_owner'=>$tag_owner));
					$stmt = $db->conn->prepare("INSERT INTO tagsAsso(tag_id, user_id) VALUES((SELECT user_id from users where user_id = :id), (SELECT tag_id from tags where tag_name = :tag))");
				$stmt->execute(array(':id'=>$user_id, ':tag'=>$tag));
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
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

function save_new_tag($db, $tag, $user_id)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT * FROM tags WHERE tag_name LIKE :tag");
		$stmt->execute(array(':tag'=>$tag));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row == "")
		{
			$stmt = $db->conn->prepare("INSERT INTO tags(tag_name) VALUES(:tag)");
			$stmt->execute(array(':tag'=>$tag));
			$stmt = $db->conn->prepare("INSERT INTO tagsAsso(tag_id, user_id) VALUES((SELECT user_id from users where user_id = :id), (SELECT tag_id from tags where tag_name = :tag))");
			$stmt->execute(array(':id'=>$user_id, ':tag'=>$tag));
		}
		else
		{
			echo 'tag already existe';
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

function get_user_tag($db, $tag_owner)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT user_tags FROM profils WHERE user_id = (SELECT user_id FROM users WHERE  pseudo = :tag_owner)");
		$stmt->execute(array(':tag_owner'=>$tag_owner));
		$tag_list = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	if (isset($tag_list['user_tags']))
	{
		$tag_tab = explode(',', $tag_list['user_tags']);
		$i = 0;

		while($i < count($tag_tab))
		{
			$str = $tag_tab[$i];

			$stmt = $db->conn->prepare("SELECT tag_name FROM tags WHERE tag_id = :str");
			$stmt->execute(array(':str'=>$str));
			$tag_name = $stmt->fetch(PDO::FETCH_ASSOC);

			if (isset($tag_name['tag_name']))
			{
				echo "#".$tag_name['tag_name']."&nbsp";
				if ($i % 4 == 0)
					echo "</br>";
			}
			$i++;
		}
	}
	else
	{
		echo "Tags";
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
			save_new_tag($db, $tag, $tag_owner);
			update_user_tags($db, $tag, $tag_owner);
		}
	}
	else if (isset($_POST['tag']))	 
	{
		$tag = $_POST['tag'];
		update_user_tags($db, $tag, $tag_owner);
	}
}
else
{
	//error
}

/* ***************************************************************************************** */

include(MODULES.'/tag/'.VIEWS.'/tag.v.php');

/* ***************************************************************************************** */
?>
