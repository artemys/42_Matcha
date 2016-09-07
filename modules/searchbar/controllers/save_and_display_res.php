<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

	if (isset($_POST['tag']))
	{
		$tag_list = $_POST['tag'];
		$tab = explode(",", $tag_list);
		$i = 0;
	
		$size = count($tab);
		echo '<table>';
		while ($i < $size)
		{
			echo'<tr><td><div class="tag_list">'.$tab[$i].'</div></td></tr>';
			$i++;
		}
		echo '</table>';	
	}

?>