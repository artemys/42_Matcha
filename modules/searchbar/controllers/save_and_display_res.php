<?php
if (isset($_POST['tag']))
{
	$tag_list = $_POST['tag'];
	$tab = explode(",", $tag_list);
	$i = 0;

	$size = count($tab);
	echo '<td>';
	while ($i < $size)
	{
		echo'<div class="tag_list">'.$tab[$i].'</div>';
		$i++;
	}
	echo '</td>';	
}
?>