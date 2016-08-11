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

	<section id="UserInfo" class="col-xs-offset-3 col-xs-offset-3">
		<section class="title">Information</section>
		<button  id="InfoBtn" onclick="toggle_visibility('InfoPopUp'); changeImage('image1'); "><img id="image1" src="Image/add.png"/></button>
		
		<section id="Placeinfo">
			<section id="Gender">
				<div type="text">I consider myself as being <?php echo get_user_gender($db, $_SESSION['user']); ?></div>
			</section>

			<section id="Sexuality">
				<div type="text">I seek someone who <?php echo get_user_sexuality($db, $_SESSION['user']); ?></div>
			</section>
		</section>
	</section>

	<section id="InfoPopUp" >
		<form method="post" action="index.php?nav=Home">
				I consider myself as being
				<select id="Gender" name="gender">
						<option value ="1" >a men</option>
						<option value ="2" >a woman</option>
						<option value ="3" >of my own kind</option>
				</select></br>

				I seek someone who
				<select id="Sexuality" name="sexuality">
						<option value ="1" >is a man</option>
						<option value ="2" >is a woman</option>
						<option value ="3" >either are own kind</option>
				</select></br>

				<button id="Ibtn" name="info"></button>
		</form>
	</section>

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

