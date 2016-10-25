<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   information.v.php                                                 :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<section class="module" id="Information">

	<section class="title">Information</section>
		<form method="post" action="index.php?nav=Home">
			<table>
				<tr>
					<td>
						I consider myself as being
					</td>

				<?php	if (isset($_GET['id'])) { ?>
					<td>
					<?php echo get_user_gender($db, $_GET['id']); ?>
					</td>
					<?php } 
						else { ?>
					<td> 
						<?php echo get_user_gender($db, $_SESSION['user_id']); ?>
					</td>
					<td>
						<select id="Gender" name="gender">
							<option value ="1" >a men</option>
							<option value ="2" >a woman</option>
							<option value ="3" >of my own kind</option>
						</select>
					</td>
					<?php } ?>
				</tr>

				<tr>
					<td>
						I seek someone who
					</td>
					<?php	if (isset($_GET['id'])) { ?>
					<td>
						<?php echo get_user_sexuality($db, $_GET['id']); ?>
					</td>
					<?php } 
							else { ?>
					<td>
					 <?php echo get_user_sexuality($db, $_SESSION['user_id']); ?>
					</td>
					<td>
						<select id="Sexuality" name="sexuality">
							<option value ="1" >is a man</option>
							<option value ="2" >is a woman</option>
							<option value ="3" >either are own kind</option>
						</select>
					</td>
						<?php } ?>
				</tr>
				<?php if (!isset($_GET['id'])) { ?>
					<tr>
						<td colspan="2">
							<input type="submit" name="validate">
						</td>
					</tr>
		<?php	} ?>
			</table>
		</form>
</section>

 <script type="text/javascript">

function toggle_visibility(id) {
    var e = document.getElementById(id);
    if (e.style.display == 'block')
       e.style.display = 'none';
    else
       e.style.display = 'block';
    }
function changeImage(id)
{
  var x = document.getElementById(id);
  var v = x.getAttribute("src");
  if(v == "Image/minus.png")
    v = "Image/add.png";
  else
    v = "Image/minus.png";
  x.setAttribute("src", v);	
}
</script>

