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

		<button id="Order" onclick="set_table_id('Screen'); visibility('Screen','block'); visibility('Order','none');">Order By</button>
		<button id="Screen" style="display: none;" onclick="set_table_id('Order'); visibility('Screen','none');visibility('Order','block');">Screen By</button>

		<table id="OrderBy">
			<tr>
				<td><button id="user_score"      onclick="get_suggestions(this.id, show_result, $(this).closest('table').attr('id'));">Score</button></td>
			</tr>
			<tr>
				<td><button id="birthdate"       onclick="get_suggestions(this.id, show_result, $(this).closest('table').attr('id'));">Age</button></td>
			</tr>
			<tr>
				<td><button id="user_public_lat" onclick="get_suggestions(this.id, show_result, $(this).closest('table').attr('id'));">Location</button></td>
			</tr>
			<tr>
				<td><button id="user_tags"       onclick="get_suggestions(this.id, show_result, $(this).closest('table').attr('id'));">Tag</button></td>
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
	 $("#sugg").html(result).show();
}

function get_suggestions(id, callback, type_of_order){
	order = document.getElementById(id).id;
	var id = '<?php echo $user_id; ?>';

	data = "orderby=" + order 
		 + "&id="     + id 
		 + "&type="   + type_of_order;
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
function set_table_id(id)
{
	switch (id)
	{
		case "Order":
		{
			$('table').attr('id','OrderBy');
			 break;
		}
		case "Screen":
		{
			$('table').attr('id','ScreenBy');
			break;
		}
		default:
		{
			$('table').attr('id','OrderBy');
		}
	}
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
function visibility(id, state) 
{
    var e = document.getElementById(id);
       e.style.display = state;
}
</script>
