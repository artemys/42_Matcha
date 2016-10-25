<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   forgotpass.v.php                                                  :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<?php
if ($_GET['log'] && $_GET['cle'])
{ 
?>
<section class="module" id="Forgotpass">
	<form method="post" action="index.php?nav=ForgotPass">
		<table>
			<tr>
				<td><label for="password_a">New_Password</label></td>
				<td><input type="password" 	name="new_password_a"  /></td>
			</tr>

			<tr>
				<td><label for="password_b">New_Password Confirmation</label></td>
				<td><input type="password" 	name="new_password_b" /></td>
			</tr>

			<tr>
				<td colspan="2"><input type="submit" name="modif" value="Modify"/></td>
			</tr>
		</table>
</form>
</section>
<?php
}
else
{
?>
<section class="module" id="Forgotpass">
	<form method="post" action="index.php?nav=ForgotPass">
	<table>
		<tr><td><input class="input" type="text" name="user" placeholder="Username" required /></td></tr>
		<tr><td><input class="input" type="text" name="mail" placeholder="E-mail" required /></td></tr>
	<button class="btn" type="submit" name="btn"/>Envoyé</button>
	</table>
	</form>
</section>
<?php } ?>