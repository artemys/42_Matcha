<?php

$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "root";
$DB_name = "matcha";

try
{	
	$conn = new PDO("mysql:host=$DB_host", $DB_user, $DB_pass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql_create_db = "CREATE DATABASE $DB_name";
	$conn->exec($sql_create_db);
	echo "Database Matcha created successfully" . "\n";
}
catch(PDOException $e)
{
	echo $e->getMessage() . "\n";
}

$conn = null;

try
{
	$conn = new PDO("mysql:host=$DB_host;dbname=$DB_name", $DB_user, $DB_pass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql_create_utable = "CREATE TABLE `$DB_name`.`users`(
   `user_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
   `pseudo` VARCHAR( 255 ) NOT NULL ,
   `firstname` VARCHAR( 255 ) NOT NULL ,
   `lastname` VARCHAR( 255 ) NOT NULL ,
   `birthdate` DATE NOT NULL , 
   `location` VARCHAR( 255 ),
   `email` VARCHAR( 60 ) NOT NULL ,
   `password` VARCHAR( 255 ) NOT NULL ,
   `last_connection` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   `activate` SMALLINT,
   `restore_key` VARCHAR(255),
   `register_key` VARCHAR(255),
    UNIQUE (`firstname`),
    UNIQUE (`lastname`),
    UNIQUE (`email`)
	) ENGINE = MYISAM ";
	$conn->exec($sql_create_utable);
	echo "Table users created successfuly.\n";
}
catch(PDOException $e)
{
	echo $e->getMessage() . "\n";
}

try
{
	$sql_create_profils_table = "CREATE TABLE `$DB_name`.`profils`(
	`user_id`  INT( 11 ) NOT NULL,
	`user_sexuality` INT( 11 ) DEFAULT 3,
	`user_gender` INT( 11 ),
	`user_bio` VARCHAR( 255 ),
	`user_tags` VARCHAR( 2000 ))";
	$conn->exec($sql_create_profils_table);
	echo "Table profils created successfuly.\n";
}
catch(PDOException $e)
{
	echo $e->getMessage() . "\n";
}

try
{
	$sql_create_ptable = "CREATE TABLE `$DB_name`.`photo`(
	`photo_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`photo_auteur` VARCHAR( 255 ) NOT NULL,
	`photo_path` VARCHAR( 255 ) NOT NULL,
	`photo_height` INT( 11 ) NOT NULL,
	`photo_width` INT( 11 ) NOT NULL,
	`photo_weight_bytes` INT( 11 ) NOT NULL,
	`photo_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`photo_number` INT( 11 ) NOT NULL)";
	$conn->exec($sql_create_ptable);
	echo "Table photo created successfuly.\n";
}
catch(PDOException $e)
{
	echo $e->getMessage() . "\n";
}

try
{
	$sql_create_tags_table = "CREATE TABLE `$DB_name`.`tags`(
	`tag_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`tag_name` VARCHAR( 225 ) NOT NULL)";
	$conn->exec($sql_create_tags_table);
	echo "Table tags created successfuly.\n";

}
catch(PDOException $e)
{
	echo $e->getMessage() . "\n";
}

try
{
	$sql_create_like_table = "CREATE TABLE `$DB_name`.`like`(
	`profils_id` INT( 11 ) NOT NULL,
	`user_name` VARCHAR( 225 ) NOT NULL,
	`profils_jaime` INT( 11 ))";
	$conn->exec($sql_create_like_table);
	echo "Table like created successfuly.\n";
}
catch(PDOException $e)
{
	echo $e->getMessage() . "\n";
}
system("mkdir ../../Uploads");

if (!file_exists("../../Uploads/"))
{
	echo "Il y a eu un probleme avec la creation du Dossier Uploads.\n";
}
else
{
	echo "Dossier Uploads cree.\n";
}

?>
