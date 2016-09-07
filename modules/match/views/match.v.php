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

<section class="" id="Match">
	<div id="searcher" class="searcher">
	<input type="text" id="field" onkeyup="search('field');">
		<div id="res"></div>
</section>

<script>

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
