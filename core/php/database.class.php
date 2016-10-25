<?php

	class Database 
	{
		public 	$conn;

		private $name;
		private $host;
		private $user;
		private $pass;

		/* ***************************************************************** */

		function set_name($name)
		{
			$this->name = $name;
		}
		function set_host($host)
		{
			$this->host = $host;
		}
		function set_user($user)
		{
			$this->user = $user;
		}
		function set_pass($pass)
		{
			$this->pass = $pass;
		}

		/* ***************************************************************** */

		function get_name()
		{
			return($this->name);
		}
		function get_host()
		{
			return($this->host);
		}
		function get_user()
		{
			return($this->user);
		}
		function get_pass()
		{
			return($this->pass);
		}

		/* ***************************************************************** */

		function connect()
		{
			try
			{
				$this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->name, $this->user, $this->pass);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}

		/* ***************************************************************** */
	}
?>
