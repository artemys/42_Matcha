<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   side.v.php                                                        :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */
?>

<?php 
    if ($user->is_loggedin())
    { 
?>
    <img id='btn' class='sidebtn' onclick="toggle_visibility('side')" src="Image/menu.png"></img>

<section class="module col-xs-2" id="side">
    <ul >
        <li id="Homebtn"   class="menu col-xs-1"><a href="index.php?nav=Home"        ><img src="Image/home.png"/></a></li>
        <li id="Searchbtn" class="menu col-xs-1"><a href="index.php?nav=Search"       ><img src="Image/search.png"/></a></li>
        <li id="Matchbtn"  class="menu col-xs-1"><a href="index.php?nav=Match"        ><img src="Image/match.png"/></a></li>
        <li id="Notifbtn"  class="menu col-xs-1"><a href="index.php?nav=Notification" ><img src="Image/notif.png"/></a></li>
    </ul>

</section>
<?php
    }
?>

 <script type="text/javascript">

function toggle_visibility(id) {
    var e = document.getElementById(id);
    if (e.style.display == 'block')
       e.style.display = 'none';
    else
       e.style.display = 'block';
    }

 </script>

