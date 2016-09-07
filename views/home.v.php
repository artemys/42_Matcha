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

<section class="content" id="Home">

	<?php
		// echo ' <div class="user_log" />Bienvenue ' . $_SESSION['user'] . ' ! </div>';
		include(PICTURE); 
		include(INFORMATION);
		include(DESCRIPTION);
		include(TAG);
	?>

</section>

<script>
 $.getJSON('http://ipinfo.io', function(data){
	

 	var str = data['loc'] + ',' + data['city'] + "," + data['postal'] + "," + data['country'];
 	var user_loc = "user_loc=" + str;
 	var user_ip = "user_ip=" + data['ip'];

 	// alert(data['ip'])
	var request = new XMLHttpRequest();
	request.open('POST', 'index.php?nav=Home', true);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
	request.send(user_ip);

	var req = new XMLHttpRequest();
	req.open('POST', 'index.php?nav=Home', true);
	req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
	req.send(user_loc);
})
</script>