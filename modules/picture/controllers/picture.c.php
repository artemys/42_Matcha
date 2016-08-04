<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   picture.c.php                                                     :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */



function get_existing_photo($db, $img_owner)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT * FROM photo WHERE :img_owner = photo_auteur");
		$stmt->execute(array(':img_owner'=>$img_owner));
		$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
		$new_photo_number = $stmt->rowCount();
		return ($new_photo_number);
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}
/* ***************************************************************************************** */

function check_photo()
{

	if (isset($_POST["ValidateUpload"]))
	{
		file_put_contents("coucou.txt", "og");

		$targetDir = "Uploads/";
		$targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);
		file_put_contents("error.txt", $_FILES["fileToUpload"]["tmp_name"]);

		// if (file_exists($_FILES["fileToUpload"]["tmp_name"]))
		// {
		// 	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		// 	if ($check !== false)
		// 	{
		// 		$uploadOk = 1;
		// 	}
		// 	else
		// 	{
		// 		$uploadOk = 0;
		// 	}
		// }
		if ($_FILES["fileToUpload"]["size"] > 500000)
		{
   			$uploadOk = 0;
		}
		if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
		{
    		$uploadOk = 0;
		}
		if (file_exists("Uploads/".$_FILES["fileToUpload"]["name"]))
		{
			$uploadOk = 0;
			//error
		}
		if ($uploadOk == 0)
		{
			$error = "there is an error with your picture please try another";
			return (false);
		}
   		else if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile))
    	{
        	$_SESSION['UploadedFile'] = $targetFile;
        	return (true);
   		}
   	 	else
    	{
    		//error
		}
	}	
}
/* ***************************************************************************************** */

function save_photo($db, $img_owner, $file_path, $img_height, $img_width, $img_weight, $new_photo_number)
{
    try
    {
    	$stmt = $db->conn->prepare("INSERT INTO photo(photo_auteur, photo_path, photo_height, photo_width, photo_weight_bytes, photo_number) VALUES (:img_owner, :file_path, :img_height, :img_width, :img_weight, :new_photo_number)");
    	$stmt->execute(array(':img_owner'=>$img_owner, ':file_path'=>$file_path, ':img_height'=>$img_height, ':img_width'=>$img_width, ':img_weight'=>$img_weight, ':new_photo_number'=>$new_photo_number));

	}
	catch(PDOException $e)
	{
			echo $e->getMessage();
	}
}
/* ***************************************************************************************** */

function get_path_file_by_number($db, $img_owner, $photo_number)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT * FROM photo WHERE :img_owner = photo_auteur AND :photo_number = photo_number");
		$stmt->execute(array(':img_owner'=>$img_owner, ':photo_number'=>$photo_number));
		$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
		if (isset($userRow['photo_path']))
		{
			return ("src=". $userRow['photo_path']);
		}
		else
		{
			return("style=display:none");
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

// function get_photo_number()
function delete_picture($db, $img_owner, $photo_number)
{
	try
	{
		$stmt = $db->conn->prepare("DELETE FROM photo WHERE :img_owner = photo_auteur AND :photo_number = photo_number");
		$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
    	if (isset($userRow['photo_path']))
		{
			unlink($userRow['photo_path']);
		}
		else
		{
			//error
		}
		$stmt->execute(array(':img_owner'=>$img_owner, ':photo_number'=>$photo_number));
		
		// $stmt = $db->
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */
$img_owner = $_SESSION['user'];
$new_photo_number = get_existing_photo($db, $img_owner);


if (check_photo() == true)
{
	$file_path = $_SESSION['UploadedFile'];
}
else
{
		//error
}
if (isset($_POST['PictureValidateBtn']) && $new_photo_number < 5 && isset($_SESSION['UploadedFile']))
{
	$file_path = $_SESSION['UploadedFile'];
	if (exif_imagetype($file_path) ==  2)
    {
        $img = imagecreatefromjpeg($file_path);
    }
    else if (exif_imagetype($file_path) == 3)
    {
	    $img = imagecreatefrompng($file_path);
    }
	$img_height = imagesx($img);
    $img_width = imagesy($img);
    $img_weight = filesize($file_path);
	save_photo($db, $img_owner, $file_path, $img_height, $img_width, $img_height, $new_photo_number);
	$_SESSION['UploadedFile'] = NULL;

}
if (isset($_POST['Del']))
{
	$photo_number = $_POST['Del'];
	delete_picture($db, $img_owner, $photo_number);
}
else
{
	// error

}


/* ***************************************************************************************** */

include(MODULES.'/picture/'.VIEWS.'/picture.v.php');

/* ***************************************************************************************** */

?>
