<?php
class DB
{
	private $servername = "localhost:3306";
	private $username = "root";
	private $password = "";
	private $db_name = "projects2022_reticket";
	private $conn = null;
	
	function __construct()
	{ 	
		$this->conn = new mysqli($this->servername, $this->username, 
				$this->password, 
				$this->db_name); 
		if ($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		} 
		return mysqli_query($this->conn, "set names utf8");
	}
	
	function getConnection()
	{
		return $this->conn;
	}
	
	function executeNonQuery($sql)
	{
		return mysqli_query($this->conn, $sql);
	}

	
	function executeQuery($query)
	{		
		$result = $this->conn->query($query);
		if ($result->num_rows > 0) {
			return $result;
		}else{
			return 0;
		}
	}
	
	function getLastID(){
		return $this->conn->insert_id;
	}
}
?>