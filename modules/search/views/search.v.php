<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   search.v.php                                                      :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
$user_id = $_SESSION['user_id'];
?>
<section class="content" id="Search">
	<table class="tableaux">
		<tr>
			<td><label for="score_interval_less">Score-</label></td>
			<td><input id="Sml" type="number" name="score_interval_less" placeholder="Enter a minimum score" min="0" ></td>
			<td><label for="score_interval_more">Score+</label></td>
			<td><input id="Smm" type="number" name="score_interval_more" placeholder="Enter a maximun score" min="0" ></td>
		</tr>
		<tr>
			<td><label for="age_interval_less">Age-</label></td>
			<td><input id="Aml" type="number" name="age_interval_less" placeholder="Enter a minimun age" min="0"></td>
			<td><label for="age_interval_more">Age+</label></td>
			<td><input id="Amm" type="number" name="age_interval_more" placeholder="Enter a maximun age" min="0"  ></td>
		</tr>
		<tr>
			<td><label for="klm_interval_less">Klm-</label></td>
			<td><input id="Kml" type="number" name="klm_interval_less" placeholder="Enter the minimum km" min="0"></td>
			<td><label for="klm_interval_more">Klm+</label></td>
			<td><input id="Kmm" type="number" name="klm_interval_more" placeholder="Enter the maximum km" min="0" ></td>
		</tr>
		<tr>
			<td><label for="searchbox">Tag</label></td>
			<td>
				<?php include (SEARCHBAR); ?>
			</td>
		</tr>
	</table>

	<div id="res"></div>
	<input type="submit" id="lauchsearch" name="valider" value="Valider" onclick="send_tag_list(); process_data(show_result, 'order_res', 'user_public_lat DESC');"/>
	<input hidden type="text" id="selectiontags" name="selection" value="">


	<button id="Order"  style="display: block" onclick="visibility('Screen', 'block'); visibility('ScreenBy', 'block'); visibility('Order', 'none');  visibility('OrderBy', 'none'); process_data(show_result, 'screen_res', null);">Order By</button>
	<button id="Screen" style="display: none"  onclick="visibility('Screen', 'none');  visibility('ScreenBy', 'none');  visibility('Order', 'block'); visibility('OrderBy', 'block'); ">Screen By</button>


	<table class="tableaux" id="OrderBy" style="display: block">
		<tr>
			<td><button id="O_scr"  onclick="process_data(show_result, 'order_res', 'user_score DESC');">Score</button></td>
		</tr>
		<tr>
			<td><button id="O_age"  onclick="process_data(show_result, 'order_res', 'birthdate');" >Age</button></td>
		</tr>
		<tr>
			<td><button id="O_loc"  onclick="process_data(show_result, 'order_res', 'user_public_lat');">Location</button></td>
		</tr>
		<tr>
			<td><button id="O_tag"  onclick="process_data(show_result, 'order_res', 'user_tags');">Tag</button></td>
		</tr>
	</table>

	<table class="tableaux" id="ScreenBy" style="display: none">
		<tr>
			<td><button id="scr"  onclick="screenby('scr_res', 'age_res', 'loc_res', 'tag_res');">Score</button></td>
		</tr>
		<tr>
			<td><button id="age"  onclick="screenby('age_res', 'scr_res', 'loc_res', 'tag_res');">Age</button></td>
		</tr>
		<tr>
			<td><button id="loc"  onclick="screenby('loc_res', 'scr_res', 'age_res', 'tag_res');">Location</button></td>
		</tr>
		<tr>
			<td><button id="tag"  onclick="screenby('tag_res', 'scr_res', 'age_res', 'loc_res');">Tag</button></td>
		</tr>
	</table>
	<section id="test"></section>
</section>

<script type="text/javascript">
function show_result(result)
{
	$("#test").html(result).show();
}

function process_data(callback, display, order)
{
	var id = '<?php echo $user_id; ?>';

	name1  = document.getElementById('Sml').name;
	name2  = document.getElementById('Smm').name;
	name3  = document.getElementById('Aml').name;
	name4  = document.getElementById('Amm').name;
	name5  = document.getElementById('Kml').name;
	name6  = document.getElementById('Kmm').name;

	value1 = document.getElementById('Sml').value;
	value2 = document.getElementById('Smm').value;
	value3 = document.getElementById('Aml').value;
	value4 = document.getElementById('Amm').value;
	value5 = document.getElementById('Kml').value;
	value6 = document.getElementById('Kmm').value;

	tags   = document.getElementById('selectiontags').value;

	data   = name1 + "=" + value1 + "&" + 
			 name2 + "=" + value2 + "&" + 
			 name3 + "=" + value3 + "&" + 
			 name4 + "=" + value4 + "&" + 
			 name5 + "=" + value5 + "&" + 
			 name6 + "=" + value6 + 

			 "&id="    + id    + 
			 "&order=" + order + 
			 "&tags="  + tags;
			 
	var xhr = new XMLHttpRequest();
	    xhr.onreadystatechange = function()
	{
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if (callback)
				callback(xhr.responseText);
		}
	};
  	xhr.open('POST', "modules/search/controllers/" + display +".php", true);
  	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  	xhr.send(data);
}
function screenby(show, hide1, hide2, hide3)
{
	show  = document.getElementById(show);

	hide1 = document.getElementById(hide1);
	hide2 = document.getElementById(hide2);
	hide3 = document.getElementById(hide3);
	hide4 = document.getElementById('default');

	show.style.display  = 'block';

	hide1.style.display = 'none';
	hide2.style.display = 'none';
	hide3.style.display = 'none';
	hide4.style.display = 'none';

}
function visibility(id, state) 
{
    var e = document.getElementById(id);
       e.style.display = state;
}
</script>
