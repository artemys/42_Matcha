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

if (isset($_GET['id'])) //marche pas//
{
	$user = $_GET['id'];
}
else
{
	$user = $user->get_user_id($db, $user);
}
if (get_online_user($db, $user) == true)
{
	$img = "online.png";
}
else
{
	$img = "outline.png";
}
?>

<section class="" id="Online">
	<img id="OnlineIndex" src="Image/<?php echo $img; ?>" />
</section>

