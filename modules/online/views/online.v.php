<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   online.v.php                                                      :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<section class="" id="Online">
	<img id="OnlineIndex" src="online.png"> 
</section>

<script>
function change_log_indicator(id)
{
	var x = document.getElementById(id);
  	var v = x.getAttribute("src");
	if (!<?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>) {
		v = "Image/outline.png";
	}
	else
		v = "Image/online.png";
		x.setAttribute("src", v); 
}
change_log_indicator("OnlineIndex");
</script>	