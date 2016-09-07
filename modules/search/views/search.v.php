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
	<form method="post" action="index?nav=Search">

	<table>
		<tr>
			<td><label for="score_interval_less">Score-</label></td>
			<td><input type="number" name="score_interval_less" placeholder="Enter a minimum score" min="0"></td>
			<td><label for="score_interval_more">Score+</label></td>
			<td><input type="number" name="score_interval_more" placeholder="Enter a maximun score" min="0"></td>
		</tr>
		<tr>
			<td><label for="age_interval_less">Age-</label></td>
			<td><input type="number" name="age_interval_less" placeholder="Enter a minimun age" min="0"></td>
			<td><label for="age_interval_more">Age+</label></td>
			<td><input type="number" name="age_interval_more" placeholder="Enter a maximun age" min="0" ></td>

		</tr>
		<tr>
			<td><label for="klm_interval_less">Klm-</label></td>
			<td><input type="number" name="klm_interval_less" placeholder="Enter the minimum km" min="0"></td>
			<td><label for="klm_interval_more">Klm+</label></td>
			<td><input type="number" name="klm_interval_more" placeholder="Enter the maximum km" min="0" ></td>
		</tr>
		<tr>
			<td><input hidden type="text" id="selectiontags" name="selection" value=""></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" id="lauchsearch" name="valider" value="Valider" onclick="send_tag_list(); test();"/></td>
		</tr>
	</table>
	</form>

		<table id="OrderBy">
			<tr>
				<td><button id="scr" onclick="test('scr'); ">Score</button></td>
			</tr>
			<tr>
				<td><button id="age" onclick="test('age'); ">Age</button></td>
			</tr>
			<tr>
				<td><button id="loc" onclick="test('loc'); ">Location</button></td>
			</tr>
			<tr>
				<td><button id="tag" onclick="test('tag'); ">Tag</button></td>
			</tr>
		</table>
	<!-- </form> -->
</section>
<script type="text/javascript">
function test(id)
{
	;
	switch (res = document.getElementById(id)) {
    case res = 'scr':
        alert('coucou'); 
        break;
    case res = 'age':
        data = "res=" + final_tab[1]; 
        break;
    case res = 'tag':
        data = "res=" + final_tab[2]; 
        break;
    default: 
        data = "res=" + final_tab[3];
}
	// alert(data);
}
</script>
<!-- <script type="text/javascript">
function send_tag_list()
{
	data = "tags_list=" + array;
  	console.log(data);
	var request = new XMLHttpRequest();
  	request.open('POST', 'index.php?nav=Search', true);
  	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  	request.send(data);
}
</script> -->