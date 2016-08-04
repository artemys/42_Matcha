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

if (isset($_GET['nav']))
{
	if (isset($_GET['statut']) && $_GET['statut'] == 'activate')
		include(MODULES.'/registration/'.CONTROLLERS.'/activate.c.php');
	else
		include(MODULES.'/registration/'.CONTROLLERS.'/registration.c.php');
}
/* ***************************************************************************************** */
?>
