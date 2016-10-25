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

			<tr><td colspan="2"><input type="text"     name="username" placeholder="Username" required /></td></tr>
			<tr><td colspan="2"><input type="password" name="password" placeholder="Password" required /></td></tr>
			<tr><td colspan="2"><input type="submit"   name="validate"          /></td></tr>

			<tr>
				<td class="navleft" ><a href="index.php?nav=ForgotPass"/>Forgotten password ?</a></td>
				<td class="right"><a href="index.php?nav=Signup" 	/>Register            </a></td>
			</tr>

		</table>

	</form>

</section>

