<?php
Class Cart
{
	private $db = null; 
	function __construct()
	{
		$this->db = new DB();
	}
	 
	function addToCart( $user_id, $ticket_id , $price, $qty , $resell_offers_id = 0){
		$sql = "INSERT INTO  cart (user_id, ticket_id, qty, price, resell_offers_id) 
			VALUES  ('$user_id' , '$ticket_id',  '$qty' , '$price', '$resell_offers_id' )";  
		return $this->db->executeNonQuery($sql);
	}
  


	function ticketExist($user_id, $ticket_id){ 
		$sql = "select * from cart where user_id = '$user_id' and ticket_id = '$ticket_id'";	
		$result = $this->db->executeQuery($sql);
		$data = "";
		
		if(gettype($result) == "object")
		{
			while($row = $result->fetch_assoc()) 
			{
				return true;
			} 
		}
		
		return false;
	}
	
	
	function getCart($user_id){ 
		$sql = "select * from cart where user_id = '$user_id'";	
		$result = $this->db->executeQuery($sql);
		$data = "";
		
		if(gettype($result) == "object")
		{
			$sum = 0 ;
			while($row = $result->fetch_assoc()) 
			{ 
				$data = $data . "<tr>";
				$data = $data . " <td>".$row["ticket_id"]."</td>"; 
				$data = $data . " <td>".$row["class_type"]."</td>"; 
				$data = $data . " <td>".$row["qty"]."</td>";  
				$data = $data . " <td>".$row["price"]." S.R</td>"; 
				$t = $row["price"] * $row["qty"];
				$sum  = $sum  + $t; 
				$data = $data . " <td>".$t." S.R</td>";  
				
				$from = ($row["resell_offers_id"] > 0) ? " From Resller " : " From Event";
				$data = $data . " <td>".$from."</td>";  
				
				$data = $data . " <td><a href='cart.php?event=remove&tid=".$row["ticket_id"]."' class='btn btn-red'>Remove</a></td>";  
				$data = $data . "</tr>";
			}
			
				$data = $data . "<tr>";
				$data = $data . " <td colspan='2'>overall Total: <strong>".$sum." S.R</strong></td>"; 
				$data = $data . " <td><a href='cart.php?event=truncate' class='btn'>Truncate Cart</a></td>";  
				$data = $data . " <td><a href='cart.php?event=payDone&totalPrice=$sum' class='btn'>Pay for tickets</a></td>";  
				$data = $data . " <td></td>"; 
				$data = $data . "</tr>";
			return $data;
		}
		else
			return "<tr><td colspan=3>No Tickets Added To your cart</td></tr>";
	}
	
	
	function truncate($user_id){
		$sql = "delete from  cart where user_id = '$user_id'";	
		return $this->db->executeNonQuery($sql);
	}
	
	function remove($user_id , $ticket_id){
		$sql = "delete from  cart where user_id = '$user_id' and ticket_id = '$ticket_id'";	 
		return $this->db->executeNonQuery($sql);
	}
	 
	function getCartCount($user_id){
		$sql = "select count(*) as cnt from cart where user_id = '$user_id'";	
		$result = $this->db->executeQuery($sql);
		$count = 0;
		
		if(gettype($result) == "object")
		{ 
			while($row = $result->fetch_assoc()) 
			{ 
				return $row["cnt"];
			}
		}
		return $count ;
	}
}

?>