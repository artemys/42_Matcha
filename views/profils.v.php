<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   search.v.php                                                      :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<section class="content" id="Search">

<?php

 	$usero = new User();
	//ne pas oublier de checker si l'id existe et si c'est pas l'id du gars qui est co//
	include(ONLINE);
	if ($usero->get_user_pic($db, $_GET['id']))
	{
		include(LIKE);
		include(CHAT);
	}
	include(PICTURE); 
	include(SCORE);
	include(INFORMATION);
	include(DESCRIPTION);
	$usero->notify_entry($db, $_GET['id'], $_SESSION['user_id'], 'visite');
	?>

	
</section>
