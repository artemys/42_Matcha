<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   registration.v.php                                                :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<section class="module col-xs-4 col-xs-offset-4 margin_top_100" id="Registration">

	<form method="post" action="index.php?nav=Signup">

		<table>
			<tr>
				<td><label for="username">Username</label></td>
				<td><input type="text" name="username" required /></td>
			</tr>

			<tr>
				<td><label for="name_a">First Name</label></td>
				<td><input type="text" name="name_a" required /></td>
			</tr>

			<tr>
				<td><label for="name_b">Last Name</label></td>
				<td><input type="text" name="name_b" required /></td>
			</tr>

			<tr>
				<td><label for="birthdate">Last Name</label></td>
				<td><input type="date" name="birthdate" required /></td>
			</tr>

			<tr>
				<td><label for="mail">Mail</label></td>
				<td><input type="text" name="mail" required /></td>
			</tr>

			<tr>
				<td><label for="password_a">Password</label></td>
				<td><input type="password" name="password_a" required /></td>
			</tr>

			<tr>
				<td><label for="password_b">Password Confirmation</label></td>
				<td><input type="password" name="password_b" required /></td>
			</tr>

			<tr>
				<td colspan="2"><input type="submit" name="validate" value="Register"/></td>
			</tr>
		</table>

	</form>

</section>
