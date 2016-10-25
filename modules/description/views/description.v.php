<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   description.v.php                                                 :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<section class="" id="Description">
	<section class="title">Description</section>

	<div id="Bio" type="text" >
  <?php 
    if (isset($_GET['id']))
    {
      echo get_user_desc($db, $_GET['id']);
    }
    else
    {
      echo get_user_desc($db, $_SESSION['user']); 
    }
  ?>
  </div>

  <?php if (!isset($_GET['id']))
  { ?>
    <button  id="BioBtn" name="modifier" onclick="toggle_visibility('BioPopUp');">Modifier</button>
  	<section id="BioPopUp">
  		<form method="post" action="index.php?nav=Home">
  			<input type="text" id="UserBio" name="BioDescr" placeholder="your description ..."></br>
  			<input type="submit" name="Bio">
  		</form>
  	</section>
<?php
  }
  ?>
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
