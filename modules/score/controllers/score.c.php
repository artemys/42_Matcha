<?php
/* ***************************************************************************************** */
/*                                                                                           */
/*                                                                       :::      ::::::::   */
/*   score.c.php       	                                               :+:      :+:    :+:   */
/*                                                                   +:+ +:+         +:+     */
/*   By: aliandie <aliandie@student.42.fr>                         +#+  +:+       +#+        */
/*                                                               +#+#+#+#+#+   +#+           */
/*   Created: 2015/10/10 10:00:00 by aliandie                         #+#    #+#             */
/*   Updated: 2015/10/10 10:00:00 by aliandie                        ###   ########.fr       */
/*                                                                                           */
/* ***************************************************************************************** */

function get_user_score($id, $db)
{
	
		$sql = "SELECT user_score from profils where user_id = :id";
		$array_param = array(':id'=>$id);
		$row = db_call($sql, $db, $array_param, 1);
		echo $row['user_score'];
}

/* ***************************************************************************************** */

/* ***************************************************************************************** */

include(MODULES.'/score/'.VIEWS.'/score.v.php');

/* ***************************************************************************************** */

?>