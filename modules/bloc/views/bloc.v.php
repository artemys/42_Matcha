<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   authentication.c.php                                              :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
$user_id = $_SESSION['user_id'];
$owner_id = $_GET['id'];
?>

<section class="modules" id="bloc">
	<button onclick="bloc_user('signal');">signal</button>
	<button onclick="bloc_user('bloc');">bloc</button>
</section>

<script type="text/javascript">
function bloc_user(type)
{
	var user_id = '<?php echo $user_id; ?>';
	var owner_id = '<?php echo $owner_id; ?>';
	var data = "user_id=" + user_id + "&owner_id=" + owner_id + "&type=" + type;
	$.ajax({
	       type: "POST",
	       url: "modules/bloc/controllers/bloc_user.php",
	       data: data,
	       cache: false,
	       dataType : 'html',
	       success: function(html)
	       	{
	       		document.location.href="index.php?nav=Home";
	        }
		});
}
</script>