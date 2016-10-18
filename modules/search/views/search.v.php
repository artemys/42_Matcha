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
	<section class="parambox tableaux">
		<table>
			<tr>
				<td><label class="title" for="score_interval_less">Score</label></td>
				<td><input id="Sml" type="number" name="score_interval_less" placeholder="Enter a minimum score" min="0" ></td>
				<td><input id="Smm" type="number" name="score_interval_more" placeholder="Enter a maximun score" min="0" ></td>
			</tr>
			<tr>
				<td><label class="title pr16" for="age_interval_less">Age</label></td>
				<td><input id="Aml" type="number" name="age_interval_less" placeholder="Enter a minimun age" min="0"></td>
				<td><input id="Amm" type="number" name="age_interval_more" placeholder="Enter a maximun age" min="0"></td>
			</tr>
			<tr>
				<td><label class="title pr16" for="klm_interval_less">Klm</label></td>
				<td><input id="Kml" type="number" name="klm_interval_less" placeholder="Enter the minimum km" min="0"></td>
				<td><input id="Kmm" type="number" name="klm_interval_more" placeholder="Enter the maximum km" min="0"></td>
			</tr>
			<tr>
				<td><label class="title pr18" for="searchbox">Tag</label></td>
				<td><?php include (SEARCHBAR); ?><div id="res"></div></td>
				<td><div id="selected"></div></td>
				<td><input hidden type="text" id="selectiontags" name="selection"></td>
			</tr>
		</table>
		<input type="submit" id="lauchsearch" name="valider" value="Valider" onclick="send_tag_list(); process_data(show_result, 'order_res', 'user_true_lat DESC');"/>
	</section>

	<section style="float: right;">
		<table class="" id="OrderBy" style="display: block">
			<tr>
				<td>
					<button id="Order"  style="display: block" onclick="visibility('Screen', 'block'); visibility('ScreenBy', 'block'); visibility('Order', 'none');  visibility('OrderBy', 'none'); process_data(show_result, 'screen_res', null);">Order By</button>
				</td>
			</tr>
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
				<td>
					<button id="Screen" style="display: none"  onclick="visibility('Screen', 'none');  visibility('ScreenBy', 'none');  visibility('Order', 'block'); visibility('OrderBy', 'block'); ">Screen By</button>
				</td>
			</tr>
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
	</section>
	<section class="finalSearch">
		<div id="result-title" class="title">Resultat from you're search</div>
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

	if(show != null)
	{
		show.style.display  = 'block';
	}
	if (hide1 != null)
	{
		hide1.style.display = 'none';
	}
	if (hide2 != null)
	{
		hide2.style.display = 'none';
	}	
	if (hide3 != null)
	{
		hide3.style.display = 'none';
	}	
	if (hide4 != null)
	{
		hide4.style.display = 'none';
	}
}
function visibility(id, state) 
{
    var e = document.getElementById(id);
       e.style.display = state;
}
</script>
