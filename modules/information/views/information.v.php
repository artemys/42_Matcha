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
		
		<section id="Gender"></section>
		<section id="Sexuality"></section>
	</section>

	<section id="InfoPopUp" >
		<form methode="post" action="index.php?nav=information">

				<select id="Gender">
						<option name = "1" value ="Men"	 >Men</option>
						<option name = "2" value ="Woman">Woman</option>
						<option name = "3" value ="Other">Other</option>
				</select></br>

				<select id="Sexuality">
						<option name = "1" value ="Men"	 >Men</option>
						<option name = "2" value ="Woman">Woman</option>
						<option name = "3" value ="Other">Other</option>
				</select></br>

				<input type="text" name="tags"></br>

				<!-- <input id="btno" type="submit" value="validate"/> -->
				<button id="CheckedBtn"><img id=image3.png src="Image/checked.png"/></button>

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

