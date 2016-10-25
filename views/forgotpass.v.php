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
if (isset($_GET['log']) && isset($_GET['cle']))
{ ?>
	
	<section class="module" id="resmdp">
		<form method="post" action="index.php?nav=ForgotPass<?php  echo "&log=".urlencode($_GET['log'])."&cle=".urlencode($_GET['cle']); ?>">
			<table>
				<tr><td><input class="input" type="password" name="pass_a" placeholder="password" required /></td></tr>
				<tr><td><input class="input" type="password" name="pass_b" placeholder="password confirmation" required /></td></tr>
				<input type="hidden" name="nomvar"  value="" />
				<input type="hidden" name="nomvar"  value="12345" />
				<td><button class="btn" type="submit" name="modif"/>Send</button></td>
			</table>
		</form>
	</section>

<?php }
else
{ ?>

<section class="module" id="Forgotpass">
	<form method="post" action="index.php?nav=ForgotPass">
		<table>
			<tr><td><input class="input" type="text" name="user" placeholder="Username" required /></td></tr>
			<tr><td><input class="input" type="text" name="mail" placeholder="E-mail" required /></td></tr>
			<td><button class="btn" type="submit" name="btn_fpass"/>Send</button></td>
		</table>
	</form>
</section>
<?php } ?> 