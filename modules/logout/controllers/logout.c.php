<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   logout.c.php                                                      :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

date_default_timezone_set('Europe/Paris');
// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');
// Afficher les erreurs et les avertissements


  if ($user->is_loggedin() == true)
  {
		include(MODULES.'/logout/'.VIEWS.'/logout.v.php');
		// if(isset($_GET['nav']) && $_GET['nav'] != "signin" && $_GET['nav'] != "signup")
		// { 
		if (isset($_POST['logout']))
		{
     		$user->logout();
			$user->redirect("index.php");
		}
		// }
     // $user->redirect('index.php');
  }

/* ***************************************************************************************** */
/* ***************************************************************************************** */
?>
