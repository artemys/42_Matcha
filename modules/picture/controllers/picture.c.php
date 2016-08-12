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
		$targetDir = "Uploads/";
		$targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);

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

// function display()
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

function delete_picture($db, $img_owner, $photo_number)
{
	try
	{
		$stmt = $db->conn->prepare("SELECT * FROM photo WHERE :img_owner = photo_auteur AND :photo_number = photo_number");
		$stmt->execute(array(':img_owner'=>$img_owner, ':photo_number'=>$photo_number));
		$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

    	if (isset($userRow['photo_path']))
		{
			unlink($userRow['photo_path']);
		}
		else
		{
			//error
		}
		$stmt = $db->conn->prepare("DELETE FROM photo WHERE :img_owner = photo_auteur AND :photo_number = photo_number");
		$stmt->execute(array(':img_owner'=>$img_owner, ':photo_number'=>$photo_number));
		
		$stmt = $db->conn->prepare("UPDATE photo SET photo_number = photo_number - 1 WHERE :photo_number < photo_number ");
		$stmt->execute(array(':photo_number'=>$photo_number));
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

function set_pic_as_profil_picture($db, $img_owner, $photo_number)
{
	try
	{
		$stmt = $db->conn->prepare("UPDATE photo AS rule1 JOIN photo AS rule2 ON ( rule1.photo_number = 0 AND rule2.photo_number = :photo_number ) SET rule1.photo_number = rule2.photo_number, rule2.photo_number = 0 WHERE rule1.photo_auteur = :img_owner AND rule2.photo_auteur = :img_owner"); // SA MERE LA TEPUUUUU
		$stmt->execute(array(':photo_number'=>$photo_number, ':img_owner'=>$img_owner));
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
if (isset($_POST['SetAsProfil']))
{
	$photo_number = $_POST['SetAsProfil'];
	set_pic_as_profil_picture($db, $img_owner, $photo_number);
}
else
{
	// error

}


/* ***************************************************************************************** */

include(MODULES.'/picture/'.VIEWS.'/picture.v.php');

/* ***************************************************************************************** */

?>
