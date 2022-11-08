<?php
class Event
{
	private $db = null;
	function __construct()
	{
		$this->db = new DB();
	}
	
	function addEvent( $title,  $description, $event_date, $img)
	{
		$sql = "INSERT INTO event ( `title`,   `description`, `event_date`, `img`) 
				VALUES ('$title', '$description', '$event_date', '$img' )"; 
		return $this->db->executeNonQuery($sql);
	}
	
	function deleteEvent($id)
	{
		$sql = "delete from event where id = '$id'";
		return $this->db->executeNonQuery($sql);
	}
	
	function getEvent($id)
	{
		$sql = "select * from event where id = '$id'";		
		$result = $this->db->executeQuery($sql);
		
		if(gettype($result) == "object")
		{
			return $row = $result->fetch_assoc();
		}else{
			return 0;
		}
		
	}
	 
	
	function editEvent($id, $title,  $description, $event_date, $img)
	{
		if($img == ""){
			$sql = "update event set title = '$title', description = '$description', event_date = '$event_date' where id = '$id' ";
		}else{
			$sql = "update event set title = '$title', description = '$description', event_date = '$event_date', img = '$img' where id = '$id' ";
		}
		return $this->db->executeNonQuery($sql);
	}
	
	function showEventsTable()
	{
		$data="";
		$sql = "select * from event ";	 
		$result = $this->db->executeQuery($sql);
		
		if(gettype($result) == "object")
		{
			while($row = $result->fetch_assoc()) 
			{
				$data = $data . "<tr>";
				$data = $data . " <td>".$row["title"]."</td>"; 
				$data = $data . " <td>".$row["event_date"]."</td>";   
				$data = $data . " <td><img src='../imgs/".$row["img"]."' width='150' height='150'/></td>"; 
				
				$data = $data . " <td> <a href='addTicket.php?event_id=".$row["id"]."'>Add Tickets</a></td>";
				$data = $data . " <td> <a href='event.php?action=edit&event_id=".$row["id"]."'>Edit</a></td>";
				$data = $data . "    <td>";
				$data = $data . "         <input type='checkbox' name='evID_$row[id]'>";
				$data = $data . "         <input type='hidden' name='evID[]' value='$row[id]'>";
				$data = $data . "    </td>";
				$data = $data . "</tr>";
			}
			return $data;
		}
		else
			return "<tr><td colspan=3>No Events Added</td></tr>";
	}
	
	
	function getNewEvents()
	{
		$data=array();
		$sql = "SELECT * FROM `event` where event_date >= now()";	 
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
	
	
	
	
}

?>