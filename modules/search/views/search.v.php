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
?>

<section class="content" id="Search">
	<form method="post" action="index?nav=Search">

	<table>
		<tr>
			<td><label for="age_interval_less">Age-</label></td>
			<td><input type="number" name="age_interval_less"></td>
			<td><label for="age_interval_more">Age+</label></td>
			<td><input type="number" name="age_interval_more"></td>

		</tr>
		<tr>
			<td><label for="score_interval_less">score-</label></td>
			<td><input type="number" name="score_interval_less"></td>
			<td><label for="score_interval_more">score+</label></td>
			<td><input type="number" name="score_interval_more"></td>
		</tr>
<!-- 		<tr>
			<td><label for="klm_interval_less">klm-</label></td>
			<td><input type="number" name="klm_interval_less"></td>
			<td><label for="klm_interval_more">klm+</label></td>
			<td><input type="number" name="klm_interval_more"></td>
		</tr> -->
<!-- 
		<tr>
			<td><label for="tags_list">Tags</label></td>
			<td><input type="text" name="tags_list"></td>
		</tr> -->
		<tr>
			<td colspan="2"><input type="submit" name="valider" value="VAlider"/></td>
		</tr>
	</table>
	</form>

</section>