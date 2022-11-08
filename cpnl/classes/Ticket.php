<?php
Class Ticket
{
	private $db = null;
	function __construct()
	{
		$this->db = new DB();
	}
	 
	function addTicket($event_id , $class_type, $price, $qty){
		$sql = "INSERT INTO  tickets (event_id , class_type, price, qty) VALUES  ('$event_id' , '$class_type', '$price', '$qty')";  
		return $this->db->executeNonQuery($sql);
	}

	function getTicketData($id)
	{
		$sql = "select * from tickets where id = '$id'";		
		$result = $this->db->executeQuery($sql);
		
		if(gettype($result) == "object")
		{
			return $row = $result->fetch_assoc();
		}else{
			return 0;
		}
		
	}
	
	
	function getTicketsOptions($id)
	{
		$sql = "select * from tickets";		
		$result = $this->db->executeQuery($sql);
		$data = "";
		if(gettype($result) == "object")
		{
			$data = "";
			while($row = $result->fetch_assoc())
			{
				$selected = ($id==$row["id"])? " selected = selected" : "";
				$data = $data . "<option value=".$row["id"]." $selected> ".$row["class_type"]." </option>";
			}
			return $data;
		}else{
			return 0;
		}
		
	} 

	function showTickets($event_id){ 
		$sql = "select * from tickets where event_id = '$event_id'";	
		$result = $this->db->executeQuery($sql);
		$data = "";
		
		if(gettype($result) == "object")
		{
			while($row = $result->fetch_assoc()) 
			{
				$data = $data . "<tr>";
				$data = $data . " <td>".$row["class_type"]."</td>"; 
				$data = $data . " <td>".$row["qty"]."</td>";  
				$data = $data . " <td>".$row["price"]."</td>";  
				$data = $data . "</tr>";
			}
			return $data;
		}
		else
			return "<tr><td colspan=3>No Tickets Added To this Event</td></tr>";
	}
	
	
	function getEventTickets($event_id){ 
		$data = array();
		$sql = "select * from tickets where event_id = '$event_id'";			 
		$result = $this->db->executeQuery($sql);
		$i =0 ;
		if(gettype($result) == "object")
		{
			while($row = $result->fetch_assoc()) 
			{
				$data[$i++] = $row; 
			}
		}
		return $data;
	}
	
	
	function updateTicketQTY( $ticket_id , $qty){
		$sql = "update tickets set qty = qty - $qty where  id ='$ticket_id'";   
		return $this->db->executeNonQuery($sql);
	}
 
}

?>