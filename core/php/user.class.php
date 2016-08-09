<?php

class User
{
	function is_loggedin()
	{
	   if (isset($_SESSION['user']))
	   {
	      return true;
	   }
	   	return false;
	}
	/* ***************************************************************** */
	
	function redirect($url)
	{
		header("Location: $url");
	}

	/* ***************************************************************** */

	function logout()
	{
		if (ini_get("session.use_cookies")) 
		{
    		$params = session_get_cookie_params();
    		setcookie(session_name(), '', time() - 42000,
        	$params["path"], $params["domain"],
        	$params["secure"], $params["httponly"]);
		}
		session_destroy();
	
	}

	/* ***************************************************************** */

}
?>
