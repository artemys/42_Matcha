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

<div id="searcher" class="searcher">
	<input type="text" id="field" onkeyup="search('field')">
	<div id="res"></div>
</div>

<script>

function search(id)
{
	var str = document.getElementById(id);
	
	var data = "str=" + str.value;
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

</script>