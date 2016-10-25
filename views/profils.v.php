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
 	if ($usero->check_id($db, $_GET['id'], $_SESSION['user_id']))
 	{
		include(SCORE);
		include(ONLINE);
		if ($usero->get_user_pic($db, $_GET['id']))
		{
			
			include(LIKE);
			include(BLOC);
		}
		include(PICTURE); 
		include(INFORMATION);
		include(DESCRIPTION);
		if ($usero->get_user_pic($db, $_GET['id']) && $usero->is_users_connected($db, $_GET['id'], $_SESSION['user_id']) == true)
		{
			include(CHAT);
		}
		$usero->notify_entry($db, $_GET['id'], $_SESSION['user_id'], 'visite');
 	}
 	else
 	{
 		$usero->redirect("index.php?nav=Home");
 	}
	?>
</section>

