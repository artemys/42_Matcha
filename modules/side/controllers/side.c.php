<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   side.c.php                                                        :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

$elem_a = 'home_a';
$elem_b = 'search_a';
$elem_c = 'match_a';
$elem_d = 'notifications_a';
$elem_e = 'settings_a';

if (isset($_GET['nav']))
{
	switch ($_GET['nav'])
	{
		case 'Home'			: $elem_a = 'home_b';          break;
		case 'Search'		: $elem_b = 'search_b';        break;
		case 'Match'		: $elem_c = 'match_b';         break;
		case 'Notifications': $elem_d = 'notifications_b'; break;
		case 'Settings'		: $elem_e = 'settings_b';      break;
	}
}

$elem_a = '<img src="'.ASSETS.'/'.$elem_a.'.png" alt="Home"          />';
$elem_b = '<img src="'.ASSETS.'/'.$elem_b.'.png" alt="Search"        />';
$elem_c = '<img src="'.ASSETS.'/'.$elem_c.'.png" alt="Match"         />';
$elem_d = '<img src="'.ASSETS.'/'.$elem_d.'.png" alt="Notifications" />';
$elem_e = '<img src="'.ASSETS.'/'.$elem_e.'.png" alt="Settings"      />';

$elem_a = '<a href="index.php?nav=Home"          alt="Home"          >'.$elem_a.'</a>';
$elem_b = '<a href="index.php?nav=Search"        alt="Search"        >'.$elem_b.'</a>';
$elem_c = '<a href="index.php?nav=Match"         alt="Match"         >'.$elem_c.'</a>';
$elem_d = '<a href="index.php?nav=Notifications" alt="Notifications" >'.$elem_d.'</a>';
$elem_e = '<a href="index.php?nav=Settings"      alt="Settings"      >'.$elem_e.'</a>';


/* ***************************************************************************************** */
	include(MODULES.'/side/'.VIEWS.'/side.v.php');
/* ***************************************************************************************** */
?>
