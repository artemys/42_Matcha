<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   match.v.php                                                       :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
$user_id = $_SESSION['user_id'];

?>
<section class='modules'>
	<section class="" id="Match">

		<div id="searcher" class="searcher">
		<input type="text" id="field" onkeyup="search('field');">
			<div id="res"></div>
		</div>

		<button id="Order">Order By</button>
		<button id="Screen">Screen By</button>
		<table id="OrderBy">
			<tr>
				<td><button id="user_score"      onclick="get_suggestions(this.id, show_result);">Score</button></td>
			</tr>
			<tr>
				<td><button id="birthdate"       onclick="get_suggestions(this.id, show_result);">Age</button></td>
			</tr>
			<tr>
				<td><button id="user_public_lat" onclick="get_suggestions(this.id, show_result);">Location</button></td>
			</tr>
			<tr>
				<td><button id="user_tags"       onclick="get_suggestions(this.id, show_result);">Tag</button></td>
			</tr>
		</table>

		<section>
			<label for="Meetable">Your suggestions</label>
			<div id="sugg"></div>
		</section>

	</section>
</secion>
<script>

window.onload = get_suggestions('user_public_lat', show_result);

function show_result(result)
{
	console.log(result);
	 $("#sugg").html(result).show();

}

function get_suggestions(id, callback){
	order = document.getElementById(id).id;
	var id = '<?php echo $user_id; ?>';

	data = 	"orderby=" +  order + "&id=" + id;
	var xhr = new XMLHttpRequest();
	    xhr.onreadystatechange = function()
	{
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if (callback)
				callback(xhr.responseText);
		}
	};
  	xhr.open('POST', "modules/match/controllers/get_match.php", true);
  	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  	xhr.send(data);
}

function search(id)
{
	var str = document.getElementById(id);
	var i = 0;
	var x = event.keyCode;
	var id = '<?php echo $user_id; ?>';
		
	var data = "str=" + str.value + "&user_id=" + id;
	$.ajax({
	       type: "POST",
	       url: "modules/match/controllers/s.php",
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
function go_toprofils($user_id)
{
	window.location='index.php?nav=Profils&id=' + $user_id;

}
function setId(id) {
    cur_id = id;
}
</script>
