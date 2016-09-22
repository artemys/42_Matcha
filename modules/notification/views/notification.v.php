<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   notification.v.php                                                :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
$user_id = $_SESSION['user_id'];
?>



<script>
(function($){ 

	$.fn.notif = function(options){
		var options = $.extend({
			html :  '<div class="notifs">\
						<div class="left">\
							<div class="icon"></div>\
						</div>\
						<div class="right">\
							<h2>Titre</h2>\
							<p>descriptions</p>\
						</div>\
					</div> '
					}, options);

					return this.each(function(){
						var $this = $(this);
						var $notifs = $('> .notif', this);
						console.log(notifs);
						if ($notifs.length == 0)
						{
							$notifs = $('<div class="notif"/>');
							$this.append($notifs);
						}
					})
				}
	$('Notifications').notif({title:'Mon titre', content: 'Mon content'});
})(jQuery);
</script>
<!-- <script>
window.onload = get_notif(show_result);;
function show_result(result)
{
	 $("#notifs").html(result).show();
}
function get_notif(callback)
{
	var id = '<?php  $user_id; ?>';
	var data = "id=" + id;
	var xhr = new XMLHttpRequest();
	    xhr.onreadystatechange = function()
	{
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if (callback)
				callback(xhr.responseText);
		}
	};
  	xhr.open('POST', "modules/notification/controllers/get_notif.php", true);
  	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  	xhr.send(data);
}

</script> -->