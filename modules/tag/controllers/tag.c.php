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

function save_old_tag($db, $tag, $user_id)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT tag_id FROM tags WHERE tag_name = :tag");
		$stmt->execute(array(':tag'=>$tag));
		$useRow = $stmt->fetch(PDO::FETCH_ASSOC);
		if (isset($useRow['tag_id']))
		{
			$tag_id = $useRow['tag_id'];
			$stmt = $db->conn->prepare("INSERT INTO tagsAsso(user_id, tag_id) VALUES((SELECT user_id from users where user_id = :id), (SELECT tag_id from tags where tag_id = :tag_id))");
			$stmt->execute(array(':id'=>$user_id, ':tag_id'=>$tag_id));
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
			$stmt = $db->conn->prepare("INSERT INTO tagsAsso(user_id, tag_id) VALUES((SELECT user_id from users where user_id = :id), (SELECT tag_id from tags where tag_name = :tag))");
			$stmt->execute(array(':id'=>$user_id, ':tag'=>$tag));
		}
		else
		{
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

function get_user_tag($db, $user_id)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT tag_name FROM tags WHERE tag_id IN (SELECT tag_id FROM tagsAsso WHERE user_id = :user_id)");
		$stmt->execute(array(':user_id'=>$user_id));
		while($tag_list = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo ' #' . $tag_list['tag_name'];
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}

}

/* ***************************************************************************************** */


if (isset($_SESSION['user']))
{
	$user_id = $_SESSION['user_id'];
	if (isset($_POST['tagbtn']))
	{
		if (isset($_POST['newtag']) && !empty($_POST['newtag']))
		{
			$tag = htmlentities($_POST['newtag']);
			save_new_tag($db, $tag, $user_id);
		}
		else
		{
			echo '<div onclick="this.remove();"class="alert alert-danger">Error, please try again</div>';
		}
	}
	else if (isset($_POST['tag']))	 
	{
		$tag = htmlentities($_POST['tag']);
		save_old_tag($db, $tag, $user_id);
	}
}

/* ***************************************************************************************** */

include(MODULES.'/tag/'.VIEWS.'/tag.v.php');

/* ***************************************************************************************** */
?>
