<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   index.php                                                         :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

session_start();
date_default_timezone_set('Europe/Paris');
// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');
// Afficher les erreurs et les avertissements

/* ***************************************************************************************** */

require_once('core/php/configuration.class.php');
require_once('core/php/database.class.php');
require_once('core/php/user.class.php');


    $db = new Database();
    $user = new User();

    $db->set_name("matcha");
    $db->set_host("localhost");
    $db->set_user("root");
    $db->set_pass("");

    $db->connect();

/* ***************************************************************************************** */
?>

<!DOCTYPE html>

<html lang="en">

	<head>
		<title>Matcha</title>

		<link rel="stylesheet" href="/core/design/bootstrap.min.css" />
		<link rel="stylesheet" href="/core/design/design.css" />
	</head>

	<body>
		<?php 
		include(HEADER);
	
		if (!isset($_GET['nav']) || $_GET['nav'] == 'Signin' || $_GET['nav'] == 'Signup')
		{
			include(CONTROLLERS.'/selector.c.php');

		}
		if ($_GET['nav'] != 'Signin' && $_GET['nav'] != 'Signup')
		{
			include (SIDE);
			include (LOGOUT);
		}
		?>

		<section id="Content">

			<?php

				if (isset($_GET['nav']))
				{
					switch($_GET['nav'])
					{
							case 'Signin' 		: include(CONTROLLERS.'/signin.c.php'		); break;
							case 'Signup' 		: include(CONTROLLERS.'/signup.c.php'		); break;
							case 'Home'			: include(CONTROLLERS.'/home.c.php'	 		); break;
							case 'Search'		: include(CONTROLLERS.'/search.c.php' 		); break;
							case 'Match'		: include(CONTROLLERS.'/match.c.php'		); break;
							case 'Notification'	: include(CONTROLLERS.'/notification.c.php'	); break;
							case 'information'  : include(CONTROLLERS.'/information.c.php'  ); break;
						default :

							include(CONTROLLERS.'/selector.c.php');

						break;
					}
				}
			?>

		</section>

		<?php include(FOOTER); ?>
	</body>

</html>
