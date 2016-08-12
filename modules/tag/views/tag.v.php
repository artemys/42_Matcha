<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   tag.v.php                   		                               :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<section class="" id="Tag">
	<section class="title">Tag</section>
	<button  id="TagBtn" onclick="toggle_visibility('TagPopUp'); changeImage('image4'); "><img id="image4" src="Image/add.png"/></button>
  
  <!-- <section id="Taglist"> -->
    <!-- <table> -->
    <?php get_user_tag($db, $_SESSION['user']); ?>
    <!-- </table> -->
  <!-- </section> -->


	<section id="TagPopUp">
		<form method="post" action="index.php?nav=Home">
			<input type="text" id="UserNewTag" name=newtag></br>
			<button id="Tbtn" name="tagbtn"></button>
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
