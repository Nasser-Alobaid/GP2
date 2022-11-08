<?php
class Users
{
	private $db = null;
	private $userID = 0; 
	
	function __construct ($db)
	{
		$this->db = $db;
	}
	
	
	function addUser($fname, $lname, $email, $phone, $username , $password )
	{
		$sql = "INSERT INTO  users (fname, lname, email, phone, username , password) VALUES 
					('$fname' , '$lname' , '$email' , '$phone',  '$username',   md5('$password'))";  
		return $this->db->executeNonQuery($sql);
	}
	
	function deleteUser($id)
	{
		$sql = "update users set fname = 'DELETED', lname = 'DELETED', username = 'DELETED', email = '', phone = '', password = '' where id = '$id'";
		return $this->db->executeNonQuery($sql);
	}
	
	function getUser($id)
	{
		$sql = "select * from  users where id = '$id'";		
		$result = $this->db->executeQuery($sql);
		
		if(gettype($result) == "object")
		{
			return $row = $result->fetch_assoc();
		}else{
			return 0;
		}
		
	}
	
	 
	
	function userLogin($email, $pass)
	{ 
		$sql = "select * from users where email = '$email' and `password`  = md5('$pass') "; 
		
		$result = $this->db->executeQuery($sql);
		
		if(gettype($result) == "object")
		{
			while($row = $result->fetch_assoc()) 
			{
				$this->setUserID($row["id"]); 
				
			}
			return 1;
		}else{
			return 0;
		}
	}
	
	
	
	function getUserID()
	{
		return $this->userID;
	}
	
	function setUserID($userID)
	{
		$this->userID = $userID;
	}
	
	  
	
	
	
	function showUsersTable()
	{
		$data="";
		$sql = "select * from users";	 
		
		$result = $this->db->executeQuery($sql);
		
		if(gettype($result) == "object")
		{
			while($row = $result->fetch_assoc()) 
			{
				$data = $data . "<tr>";
				$data = $data . " <td>".$row["fname"]."</td>";
				$data = $data . " <td>".$row["lname"]."</td>";
				$data = $data . " <td>".$row["username"]."</td>";
				$data = $data . " <td>".$row["phone"]."</td>";
				$data = $data . " <td>".$row["email"]."</td>"; 
				$data = $data . " <td><a href='orders.php?user_id=".$row["id"]."' target='_blank'>User Orders/Tickets</a></td>";  
				$data = $data . " <td><a href='reselled.php?user_id=".$row["id"]."' target='_blank'>User Offers/Reselled Tickets</a></td>"; 
				if($row["fname"] == "DELETED" && $row["password"] == ""){
					$data = $data . " <td> USER DELETED</td>"; 
				}else{	
					$data = $data . " <td><button class='bnt' onclick='deleteUser(\"".$row["id"]."\" , \"".$row["fname"]."\")'>Delete User</button></td>";  
				}
				$data = $data . "</tr>";
			}
			return $data;
		}
		else
			return "<tr><td colspan=3>Empty Table</td></tr>";
	}
	
	 

	
}

?>