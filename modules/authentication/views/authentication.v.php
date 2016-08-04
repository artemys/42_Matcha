<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   authentication.v.php                                              :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<section class="module col-xs-4 col-xs-offset-4 margin_top_100" id="Authentication">
	
		<form method="post" action="index.php?nav=signin">

			<table>
				<tr>
					<td><label for="username">Pseudo</label></td>
					<td><input type="text" name="username" placeholder="Pseudo" required /></td>

				</tr>

				<tr>
					<td><label for="password">Password</label></td>
					<td><input type="password" name="password" placeholder="Password" required /></td>
				</tr>

				<tr>
					<td colspan="2"><input type="submit" name="validate" value="Connect"/></td>
				</tr>
			</table>
</section>
