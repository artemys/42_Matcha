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

<div id="owned_not"></div>



<script>
// window.onload = get_notif(show_result);

function show_result(result)
{
	 $("#owned_not").html(result).show();
}
function get_notif(callback)
{
	var id = '<?php echo $user_id; ?>';
	var data = "id=" + id;
	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function()
	{
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if (callback)
				callback(xhr.responseText);
				// console.log(JSON.parse(xhr.responseText)[0]);
				// $('.test').notif({title:'Mon titre', content:'Mon contenu'});
			}
	};
  	xhr.open('POST', "modules/notification/controllers/get_notif.php", true);
  	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  	xhr.send(data);
	// console.log('coucou');
  	// setTimeout('get_notif(show_result)', 2000); 
}

function delete_history(id)
{
	var data = "id=" + id;
	console.log(data);
	var xhr = new XMLHttpRequest();
  	xhr.open('POST', "modules/notification/controllers/delete_history.php", true);
  	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  	xhr.send(data);
}
get_notif(show_result);
</script>