<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   like.v.php                              	                       :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */


$id = $_GET['id'];
?>

<section class="" id="Score">
	<?php have_liked($db, $_SESSION['user_id']); ?>
</section>

<script type="text/javascript">

function send_data(id)
{
	var user_id = <?php echo $id; ?>;
	var data = "score=" + id;
	var request = new XMLHttpRequest();
	request.open('POST', 'index.php?nav=Profils&id='+ user_id, true);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
	request.send(data);
}

function switch_btn()
{
    var e = document.getElementsByClassName('scorebtn');
    if (e[0].value == 'Like')
    {
    	e[0].onclick = function()
    	{
    		send_data('Dislike');
    		switch_btn();
    	};
    	e[0].value = 'Dislike';
    }
    else if (e[0].value == 'Dislike')
    {
    	e[0].onclick = function()
    	{
    		send_data('Like');
    		switch_btn();
    	};
    	e[0].value = 'Like';
    }
}

</script>