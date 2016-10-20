<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   configuration.class.php                                           :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

define('MODULES',     'modules',        			false);
define('VIEWS',       'views',           			false);
define('CONTROLLERS', 'controllers',     			false);
define('CONTENT',     'content',         			false);
define('DESIGN',      'core/design',     			false);
define('PHP',         'core/php',        			false);
define('JAVASCRIPT',  'core/javascript', 			false);
define('ASSETS',	  '/core/design/matcha/assets', false);

/* ***************************************************************************************** */

define('HEADER',         MODULES.'/header/index.php',         false);
define('FOOTER',         MODULES.'/footer/index.php',         false);
define('SIDE',           MODULES.'/side/index.php',           false);
define('AUTHENTICATION', MODULES.'/authentication/index.php', false);
define('REGISTRATION',   MODULES.'/registration/index.php',   false);
define('MATCH',          MODULES.'/match/index.php',          false);
define('SEARCH',         MODULES.'/search/index.php',         false);
define('NOTIFICATION',   MODULES.'/notification/index.php',   false);
define('LOGOUT',		 MODULES.'/logout/index.php',		  false);
define('PICTURE',		 MODULES.'/picture/index.php',		  false);
define('INFORMATION',	 MODULES.'/information/index.php',    false);
define('DESCRIPTION',	 MODULES.'/description/index.php',    false);
define('TAG',			 MODULES.'/tag/index.php',		      false);
define('LIKE',			 MODULES.'/like/index.php',			  false);
define('CHAT',			 MODULES.'/chat/index.php',			  false);
define('BLOC',			 MODULES.'/bloc_signal/index.php',	  false);
define('ONLINE',		 MODULES.'/online/index.php',		  false);
define('FORGOTPASS',	 MODULES.'/forgotpass/index.php',	  false);
define('SEARCHBAR',		 MODULES.'/searchbar/index.php',	  false);
define('SETTINGS',		 MODULES.'/settings/index.php',		  false);
define('PROFILS',		 MODULES.'/profils/index.php',		  false);
define('SCORE',		 	 MODULES.'/score/index.php',  		  false);


/* ***************************************************************************************** */
?>
