<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   settings.v.php            		                               :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
$user_id = $_SESSION['user_id'];

?>

<section class='module' id='settings'>
	<section id="SettingPopup">
		<div class="title">Change you're informations here</div>
		<form method="post" action="index.php?nav=Settings">
	
			<table>
				<tr>
					<td><label for="username">Username</label></td>
					<td><input type="text" 		name="new_username"  /></td>
				</tr>
	
				<tr>
					<td><label for="name_a">First Name</label></td>
					<td><input type="text" 		name="new_name_a"  /></td>
				</tr>

				<tr>
					<td><label for="name_b">Last Name</label></td>
					<td><input type="text" 		name="new_name_b"  /></td>
				</tr>

				<tr>
					<td><label for="mail">Mail</label></td>
					<td><input type="text" 		name="new_mail"  /></td>
				</tr>

				<tr>
					<td><label for="password_a">New_Password</label></td>
					<td><input type="password" 	name="new_password_a"  /></td>
				</tr>

				<tr>
					<td><label for="password_b">New_Password Confirmation</label></td>
					<td><input type="password" 	name="new_password_b" /></td>
				</tr>

				<tr>
					<td colspan="2"><input type="submit" name="modif" value="Modify"/></td>
				</tr>
			</table>
		</form>
	</section>
	<div id="CitySearch" class="searcher">
	<div class="title">Select new city here</div>
		<input type="text" id="field" onkeyup="search('field')">
		<div id="res"></div>
	</div>
</section>
	<div style="display: none;" onclick="this.remove();" id="messageBox" class="alert alert-success"></div>

<script type="text/javascript">


function toggle_visibility(id) {
    var e = document.getElementById(id);
    if (e.style.display == 'block')
       e.style.display = 'none';
    else
       e.style.display = 'block';
    }

function search(id)
{
	var str = document.getElementById(id);
	
	var data = "str=" + str.value;
	$.ajax({
	       type: "POST",
	       url: "modules/settings/controllers/s.php",
	       data: data,
	       cache: false,
	       dataType : 'html',
	       success: function(html)
	       		{
	              $("#res").html(html).show();
	           	}
	   });
	         return false;

}
function send_data()
{
	var new_loc = document.getElementById(cur_id).value;
	var res = document.getElementById('field');

	var id = '<?php echo $user_id; ?>';
	$.ajax({
	       type: "POST",
	       url: "modules/settings/controllers/save_new_location.php",
	       data: "new_loc=" + new_loc + "&user_id=" + id,
	       success: function(html)
	       {
	       		$("#res").html(html).hide();
	            res.value = "";
			 	$('#messageBox').html("Location successfully modified");
			 	$('#messageBox').show();
	       }
	   });
}
function setId(id) {
    cur_id = id;
}

</script>
