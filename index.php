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
require_once('core/php/geoip/geoip.inc');


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
		<meta charset="utf-8" />
		<title>Matcha</title>

		<link rel="stylesheet" href="/core/design/matcha.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 		<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

	</head>

	<body>
		<?php 
		include(HEADER);
		echo $_SESSION['user'];
		echo $_SESSION['user_id'];
		// if (!isset($_GET['nav']) || $_GET['nav'] == 'Signin' || $_GET['nav'] == 'Signup')
		// {
		// 	include(CONTROLLERS.'/selector.c.php');

		// }
		// if (isset($_GET['nav']) && $_GET['nav'] != 'Signin' && $_GET['nav'] != 'Signup')
		// {
		// 	include (SIDE);
		// }
		?>

		<section id="Content">

			<?php
				include(SIDE);
				if (isset($_GET['nav']))
				{
					switch($_GET['nav'])
					{
							case 'Signin' 		: include(CONTROLLERS.'/signin.c.php'		); break;
							case 'Signup' 		: include(CONTROLLERS.'/signup.c.php'		); break;
							case 'Search'		: include(CONTROLLERS.'/search.c.php' 		); break;
							case 'Match'		: include(CONTROLLERS.'/match.c.php'		); break;
							case 'Notification'	: include(CONTROLLERS.'/notification.c.php'	); break;
							case 'Information'  : include(CONTROLLERS.'/information.c.php'  ); break;
							case 'Logout'		: include(CONTROLLERS.'/logout.c.php'		); break;
							case 'Settings'		: include(CONTROLLERS.'/settings.c.php'		); break;
							case 'Search'		: include(CONTROLLERS.'/search.c.php'		); break;
							case 'Profils'		: include(CONTROLLERS.'/profils.c.php'		); break;

						default :

							include(CONTROLLERS.'/home.c.php');

						break;
					}
				}
				else
				{
					include(CONTROLLERS.'/home.c.php');
				}

			?>

		</section>

		<?php include(FOOTER); ?>
	</body>

</html>
