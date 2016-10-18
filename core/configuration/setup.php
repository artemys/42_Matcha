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
   `user_id`      INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
   `pseudo`       VARCHAR( 255 ) NOT NULL ,
   `firstname`      VARCHAR( 255 ) NOT NULL ,
   `lastname`       VARCHAR( 255 ) NOT NULL ,
   `birthdate`      DATE NOT NULL ,
   `location`       VARCHAR( 255 ),
   `email`        VARCHAR( 60 ) NOT NULL ,
   `password`       VARCHAR( 255 ) NOT NULL ,
   `last_connection`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   `last_deconnection`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   `user_ip`      VARCHAR( 15 ),
   `activate`       SMALLINT,
   `restore_key`    VARCHAR( 255 ),
   `register_key`     VARCHAR( 255 ),
    UNIQUE (`firstname`),
    UNIQUE (`lastname`),
    UNIQUE (`email`)
  ) ENGINE = InnoDB";
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
	`user_id`  		  		INT( 11 ) NOT NULL,
	`user_sexuality`  		INT( 11 ) DEFAULT 3,
	`user_gender` 	  		INT( 11 ),
	`user_bio` 		 		VARCHAR( 255 ),
	`user_tags` 	  		VARCHAR( 2000 ),
 	`user_score`  	  		INT ( 11 ) DEFAULT 0,
 	`user_like`		  		VARCHAR( 2000 ),
 	`user_true_long`		VARCHAR( 255 ),
 	`user_true_lat`			VARCHAR( 255 ),
 	`user_true_city`		VARCHAR( 255 ),
 	`user_true_city_code` 	INT( 11 ),
 	`user_true_country`		VARCHAR( 5 ),
  `user_public_long`    VARCHAR( 255 ),
  `user_public_lat`     VARCHAR( 255 ),
 	`user_public_city`		VARCHAR( 255 ),
 	`user_public_city_code`	INT( 11),
 	`user_public_country`	VARCHAR(5))";
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
	`photo_id` 			 INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`photo_auteur` 		 INT( 11 ) NOT NULL,
	`photo_path` 		 VARCHAR( 255 ) NOT NULL,
	`photo_height` 		 INT( 11 ) NOT NULL,
	`photo_width` 		 INT( 11 ) NOT NULL,
	`photo_weight_bytes` INT( 11 ) NOT NULL,
	`photo_date` 		 TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`photo_number` 		 INT( 11 ) NOT NULL)";
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
	`tag_id`   INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
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
	$sql_create_like_table = "CREATE TABLE `$DB_name`.`score`(
	`profils_id` 	INT( 11 ) NOT NULL,
	`user_name` 	VARCHAR( 225 ) NOT NULL,
	`profils_score` INT( 11 ))";
	$conn->exec($sql_create_like_table);
	echo "Table like created successfuly.\n";
}
catch(PDOException $e)
{
	echo $e->getMessage() . "\n";
}
try
{
  $sql_creat_associative_tag_table = "CREATE TABLE `$DB_name`.`tagsAsso`(
  `user_id` INT(11) not null,
  `tag_id`  INT(11) not null, 
  Foreign key (user_id) 
  References users(user_id),
  foreign key (tag_id) 
  references tags(tag_id)
  )engine=InnoDB";
  $conn->exec($sql_creat_associative_tag_table);
  echo "Table assoc_tag created successfuly.\n";
}
catch(PDOException $e)
{
  echo $e->getMessage() . "\n";
}
try
{
  $conn = new PDO("mysql:host=$DB_host", $DB_user, $DB_pass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql_create_city_table = "CREATE TABLE IF NOT EXISTS `$DB_name`.`villes_france_free` (
  `ville_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ville_departement` varchar(3) DEFAULT NULL,
  `ville_slug` varchar(255) DEFAULT NULL,
  `ville_nom` varchar(45) DEFAULT NULL,
  `ville_nom_simple` varchar(45) DEFAULT NULL,
  `ville_nom_reel` varchar(45) DEFAULT NULL,
  `ville_nom_soundex` varchar(20) DEFAULT NULL,
  `ville_nom_metaphone` varchar(22) DEFAULT NULL,
  `ville_code_postal` varchar(255) DEFAULT NULL,
  `ville_commune` varchar(3) DEFAULT NULL,
  `ville_code_commune` varchar(5) NOT NULL,
  `ville_arrondissement` smallint(3) unsigned DEFAULT NULL,
  `ville_canton` varchar(4) DEFAULT NULL,
  `ville_amdi` smallint(5) unsigned DEFAULT NULL,
  `ville_population_2010` mediumint(11) unsigned DEFAULT NULL,
  `ville_population_1999` mediumint(11) unsigned DEFAULT NULL,
  `ville_population_2012` mediumint(10) unsigned DEFAULT NULL COMMENT 'approximatif',
  `ville_densite_2010` int(11) DEFAULT NULL,
  `ville_surface` float DEFAULT NULL,
  `ville_longitude_deg` float DEFAULT NULL,
  `ville_latitude_deg` float DEFAULT NULL,
  `ville_longitude_grd` varchar(9) DEFAULT NULL,
  `ville_latitude_grd` varchar(8) DEFAULT NULL,
  `ville_longitude_dms` varchar(9) DEFAULT NULL,
  `ville_latitude_dms` varchar(8) DEFAULT NULL,
  `ville_zmin` mediumint(4) DEFAULT NULL,
  `ville_zmax` mediumint(4) DEFAULT NULL,
  PRIMARY KEY (`ville_id`),
  UNIQUE KEY `ville_code_commune_2` (`ville_code_commune`),
  UNIQUE KEY `ville_slug` (`ville_slug`),
  KEY `ville_departement` (`ville_departement`),
  KEY `ville_nom` (`ville_nom`),
  KEY `ville_nom_reel` (`ville_nom_reel`),
  KEY `ville_code_commune` (`ville_code_commune`),
  KEY `ville_code_postal` (`ville_code_postal`),
  KEY `ville_longitude_latitude_deg` (`ville_longitude_deg`,`ville_latitude_deg`),
  KEY `ville_nom_soundex` (`ville_nom_soundex`),
  KEY `ville_nom_metaphone` (`ville_nom_metaphone`),
  KEY `ville_population_2010` (`ville_population_2010`),
  KEY `ville_nom_simple` (`ville_nom_simple`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36831";
	$conn->exec($sql_create_city_table);
	echo "Table city created successfuly.\n";


	$sql_import_city_data ="LOAD DATA INFILE '/nfs/2014/a/aliandie/Downloads/workspace/core/configuration/villes_france.csv' INTO TABLE matcha.villes_france_free FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ";
	$conn->exec($sql_import_city_data);
	echo "City data imported successfuly.\n";
}
catch(PDOException $e)
{
	echo $e->getMessage() . "\n";
}

try
{
  $sql_create_notif_table = "CREATE TABLE `$DB_name`.`notif`(
  `notif_id`  INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `owner_id`  INT( 11 ) NOT NULL,
  `guest_id`  INT( 11 ) NOT NULL,
  `content`   VARCHAR( 22 ),
  `seen`      INT( 11 ))";
  $conn->exec($sql_create_notif_table);
  echo "Table notif created successfuly.\n";
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
