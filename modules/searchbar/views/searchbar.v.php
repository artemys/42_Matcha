<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   searchbar.v.php            		                                   :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<div id="searcher" name="searchbox">
	<input type="text" id="field" onkeyup="search('field');">
</div>
<div id="selected"></div>
<script>

var array = new Array();
var id_array = new Array();
function search(id)
{
	var str = document.getElementById(id);
	var i = 0;
	var x = event.keyCode;
	
	var data = "str=" + str.value + "&array=" + array;
	$.ajax({
	       type: "POST",
	       url: "modules/searchbar/controllers/s.php",
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
	var tag = document.getElementById(cur_id).value;
	var id = cur_id;
	var res = document.getElementById('field');
	array.push(tag);
	id_array.push(cur_id);
	var data = "tag=" + array;

	$.ajax({
	       type: "POST",
	       url: "modules/searchbar/controllers/save_and_display_res.php",
	       data: data,
	       cache: false,
	       dataType : 'html',
	       success: function(html)
	       		{
	              $("#selected").html(html).show();
	              $("#res").html(html).hide();
	       	       res.value = "";
	           	}
	   });
}
function setId(id) {
    cur_id = id;
}
function send_tag_list()
{
	var list = document.getElementById('selectiontags');
	list.value = id_array;
}

</script>