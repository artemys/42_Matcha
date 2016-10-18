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

<section class="module" id="Registration">

	<form method="post" action="index.php?nav=Signup">

		<table>

			<tr><td><label for="username">Username  </label><input type="text"     name="username"   placeholder="" required /></td></tr>
			<tr><td><label for="username">Mail      </label><input type="text"     name="mail"       placeholder="" required /></td></tr>
			<tr><td><label for="username">First name</label><input type="text"     name="name_a"     placeholder="" required /></td></tr>
			<tr><td><label for="username">Last name </label><input type="text"     name="name_b"     placeholder="" required /></td></tr>
			<tr><td><label for="username">Birth     </label><input type="date"     name="birthdate"  placeholder="YYYY-MM-DD" required /></td></tr>
			<tr><td><label for="username">Password  </label><input type="password" name="password_a" placeholder="" required /></td></tr>
			<tr><td><label for="username">Password  </label><input type="password" name="password_b" placeholder="" required /></td></tr>

			<tr><td><input type="submit" name="validate" /></td></tr>

		</table>

	</form>

</section>
