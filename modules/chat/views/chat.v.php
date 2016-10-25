<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   chat.v.php                                                        :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
$s_id = $_SESSION['user_id'];
$r_id = $_GET['id'];

?>
<section  class="module" id="Chat">
	<button class="boutton" id="chatbtn" onclick="toggle_visibility('win'); get_old_message(show_result);" >Chat</button>

	<section class="module" id="win" style="display: none;">
		<section id="history">
        	<div class="chatContent"></div>
		</section>
   	 	<input type="text" name="sendbox" id="MBox">
   		<input type="submit" name="envoyez" value="Send" id="CSend" onclick="send_message(); ">
    </section>
</section>


<script type="text/javascript">
function show_result(result)
{
	$(".chatContent").html(result).show();
}

function toggle_visibility(id) {
var e = document.getElementById(id);
if (e.style.display == 'block')
   e.style.display = 'none';
else
   e.style.display = 'block';
}
function get_old_message(callback)
{
	var sender_id = '<?php echo $s_id; ?>';
	var reciver_id = '<?php echo $r_id; ?>';
	var data = "s_id=" + sender_id + "&r_id=" + reciver_id;
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if (callback)
				callback(xhr.responseText);
		}
	};
  	xhr.open('POST', "modules/chat/controllers/get_old_message.php", true);
  	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  	xhr.send(data);
	$("#history").scrollTop(function() { return this.scrollHeight; }); 
}
function send_message()
{
	var message = document.getElementById('MBox').value;
	document.getElementById("MBox").value = "";
	var sender_id = '<?php echo $s_id; ?>';
	var reciver_id = '<?php echo $r_id; ?>';
	var data = "s_id=" + sender_id + "&r_id=" + reciver_id + "&message=" + message;
	var xhr = new XMLHttpRequest();
  	xhr.open('POST', "modules/chat/controllers/save_message.php", true);
  	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  	xhr.send(data);
	setInterval('get_old_message(show_result)', 2000);
}

</script>
