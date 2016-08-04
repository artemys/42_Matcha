<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   home.v.php                                                        :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<section class="content col-xs-8 col-xs-offset-2" id="Home">

	
		
	<!-- CODE -->
	<?php
		// echo ' <div class="user_log" />Bienvenue ' . $_SESSION['user'] . ' ! </div>';
		include(ONLINE);
		
		include(LIKE);
		include(CHAT);
		include(PICTURE); 
		include(INFORMATION);
		include(DESCRIPTION);
		// include(BLOC);
		include(TAG);

	?>


</section>
