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

<section class="module" id="Authentication">

	<form method="post" action="index.php?nav=Signin">

		<table>

			<tr><td colspan="2"><input type="text"     name="username" required /></td></tr>
			<tr><td colspan="2"><input type="password" name="password" required /></td></tr>
			<tr><td colspan="2"><input type="submit"   name="validate"          /></td></tr>

			<tr>
				<td class="left" ><a href="#"                      	/>Forgotten password ?</a></td>
				<td class="right"><a href="index.php?nav=Signup" 	/>Register            </a></td>
			</tr>

		</table>

	</form>

</section>

