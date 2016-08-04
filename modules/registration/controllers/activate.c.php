<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   activate.c.php                                                    :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

function activate_account($db, $pseudo)
{
	try
	{
		$stmt = $db->conn->prepare("UPDATE users SET activate = 1 WHERE pseudo=:pseudo");
		$stmt->execute(array(':pseudo'=>$pseudo));
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

/* ***************************************************************************************** */

if(isset($_GET['log']))
{
	$pseudo = htmlentities($_GET['log']);
}
if (isset($_GET['cle']))
{
	$ucle = htmlentities($_GET['cle']);
}
$stmt = $db->conn->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
$stmt->execute(array(':pseudo'=>$pseudo));
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
$cle = $userRow['register_key'];

if (isset($cle) && isset($ucle))
{
	if ($cle == $ucle)
	{
		activate_account($db, $pseudo);
		echo "<div class='margin_top_20 text-center col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 alert alert-success'>Votre compte a bien ete activer</div>";
	}
}
else
{
	echo "<div class='margin_top_20 text-center col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 alert alert-danger'>Erreur, votre compte ne peut etre activer</div> ";
}
?>