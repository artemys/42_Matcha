<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   logout.v.php                                                      :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<section  class="module" id="Logout">
 <?php

  if (isset($_SESSION['user']))
  {
   echo '
   <section class="right">

    <ul>
     <li>
      <a href="index.php?nav=Logout" alt="Disconnect">

       <img src="'.ASSETS.'/disconnect.png" alt="Disconnect" />

      </a>
     </li>
    </ul>

   </section>';
  }

 ?>
</section>
