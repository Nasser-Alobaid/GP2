<?php
Class Order
{
	private $db = null;
	private $cartObj = null;
	private $ticketOb = null;
	
	function __construct($cartOb , $ticketOb)
	{
		$this->db = new DB();
		$this->cartObj = $cartOb;
		$this->ticketOb = $ticketOb;
	}
	 
	function payDone( $user_id, $totalPrice, $cartObj){
		$orderDone = false;
		$order_id  = 0;
		if($cartObj->getCartCount($user_id) > 0){
			$sql = "INSERT INTO  orders (order_date, cust_id, totalPrice) 
						VALUES  (now() , '$user_id',  '$totalPrice' )";  
			if($this->db->executeNonQuery($sql)){
				$order_id = $this->db->getLastID();
				$sql = "select * from cart where user_id = '$user_id'";	
				$result = $this->db->executeQuery($sql);
				$data = ""; 
				if(gettype($result) == "object")
				{ 
					while($row = $result->fetch_assoc()) 
					{ 
						if($row["resell_offers_id"] == 0){
							$availableQty = $this->ticketOb->getTicketData($row["ticket_id"])["qty"];
							if( $availableQty  > $row["qty"]){
								$sql = "INSERT INTO  order_details (order_id , ticket_id , qty , price , offer_id) 
									VALUES  ($order_id , '".$row["ticket_id"]."',  '".$row["qty"]."' , '".$row["price"]."', '".$row["resell_offers_id"]."' )";   
								if($this->db->executeNonQuery($sql)){ 
									$orderDone = true;
									
									if($this->ticketOb->updateTicketQTY( $row["ticket_id"], $row["qty"])){ 
										$orderDone = true;
									}else{
										$orderDone = false;
										break;
									}
								}else{
									$orderDone = false;
								}
							} else{
								$orderDone = false;
							}
						}else{
							$sql = "INSERT INTO  order_details (order_id , ticket_id , qty , price , offer_id) 
									VALUES  ($order_id , '".$row["ticket_id"]."',  '".$row["qty"]."' , '".$row["price"]."', '".$row["resell_offers_id"]."' )";   
							
							if($this->db->executeNonQuery($sql)){ 
								$orderDone = true;
								
								if($this->updateSellerQty($row["resell_offers_id"], $user_id)){ 
									$orderDone = true;
								}else{
									$orderDone = false;
									break;
								}
							}else{
								$orderDone = false;
							}
						}
					}  
				}			 
			} 
		}
		if($orderDone){
			$cartObj->truncate($user_id);
		}else{
			$sql = "delete from orders where id = $order_id";  
			$this->db->executeNonQuery($sql);
			$sql = "delete from order_details where order_id = $order_id";  
			$this->db->executeNonQuery($sql);
		}
		return $orderDone;		
	}
 
 
	
	function getOrderdTickets($user_id, $isAdmin = false, $userOb = null){ 
		$userCond = ($user_id != 0) ? "AND orders.cust_id= '$user_id'" :"";
		$sql = "select *, 
					tickets.price as orginal_price, 
					order_details.price as sell_price, 
					order_details.qty as my_qty ,
					event.id as evid,
					order_details.id as order_details_id
				from orders, order_details, event, tickets where  
					orders.id =  order_details.order_id and   
					event.id = tickets.event_id AND
					order_details.ticket_id = tickets.id  
					$userCond
					order by orders.id DESC ";	
					
		$result = $this->db->executeQuery($sql);
		$data = "";
		
		if(gettype($result) == "object")
		{
			$sum = 0 ;
			while($row = $result->fetch_assoc()) 
			{ 
				$data = $data . "<tr>";
				$path = "";
				if($isAdmin){
					$path = "../";
					$customer = $userOb->getUser($row["cust_id"]);
					$data = $data . " <td>".$customer["fname"]." ".$customer["lname"]."</td>"; 
					$data = $data . " <td>".$customer["phone"]."</td>"; 
					$data = $data . " <td>".$customer["email"]."</td>"; 
				}
				$data = $data . " <td><a href='".$path."event_details.php?id=".$row["evid"]."' target='_blank'>".$row["title"]."</a></td>"; 
				$data = $data . " <td>".$row["event_date"]."</td>"; 
				$data = $data . " <td>".$row["my_qty"]."</td>";  
				$data = $data . " <td>".$row["class_type"]."</td>";  
				$data = $data . " <td>".$row["order_date"]."</td>";  
				if($row["offer_id"] > 0){
					$data = $data . " <td>".$row["sell_price"]." S.R</td>"; 
				}else{
					$data = $data . " <td>".$row["orginal_price"]." S.R</td>";
				}					
				if(!$isAdmin){
					if($this-> ticketAlreadyOffered($user_id, $row["order_details_id"])){
						
						$data = $data . " <td>Aleardy added to offers list</td>";  
					}
					else{
						if($row["offer_id"] > 0){
							$data = $data . " <td>You can not resell this ticket</td>";  
						}else{
							$data = $data . " <td><input type='number' min='".$row["orginal_price"]."' value='".$row["orginal_price"]."' id='oid_". $row["order_details_id"]."'></td>"; 
							$oid = $row["order_details_id"];
							$data = $data . " <td><button onclick=\"resell('$oid')\">Resell</button></td>"; 
						}
					}
				}else{
					if($row["offer_id"] > 0){
						$data = $data . " <td>Offered for sale</td>";  
					}else{
						$data = $data . " <td> - </td>"; 
					}
				}
				$data = $data . "</tr>";
			}
			 
			return $data;
		}
		else
			return "<tr><td colspan=3>You didn't buy any tickets</td></tr>";
	}
	
	

	function getOfferedTickets($user_id ,  $isAdmin = false, $userOb = null){ 
		$userCond = ($user_id > 0) ? "AND event_date >= now() and
					resell_offers.user_id = '$user_id'" :"";
		$sql = "select *, 
					resell_offers.price as new_price,  
					event.id as evid,
					order_details.id as order_details_id,
					order_details.price as orginal_price,
					resell_offers.id as resell_offers_id
				from resell_offers, order_details, event, tickets where  
					resell_offers.order_details_id =  order_details.order_id and   
					event.id = tickets.event_id AND
					order_details.ticket_id = tickets.id 
					$userCond  
					order by resell_offers.id DESC ";	
		 
		$result = $this->db->executeQuery($sql);
		$data = "";
		
		if(gettype($result) == "object")
		{
			$sum = 0 ;
			while($row = $result->fetch_assoc()) 
			{ 
				$data = $data . "<tr>";
				$path = ($isAdmin) ? "../":"";
				$data = $data . " <td><a href='".$path."event_details.php?id=".$row["evid"]."' target='_blank'>".$row["title"]."</a></td>"; 
				$data = $data . " <td>".$row["event_date"]."</td>"; 
				$data = $data . " <td>One Ticket</td>";  
				$data = $data . " <td>".$row["class_type"]."</td>"; 
				$data = $data . " <td>".$row["new_price"]." S.R</td>"; 
				$data = $data . " <td>".$row["offer_dater"]."</td>"; 
				$status = ($row["status"] == 0)? "Still on offers list" : " Ticket Sold ";
				$data = $data . " <td>$status</td>"; 
				if($isAdmin){ 
					$seller = $userOb->getUser($row["user_id"]);
					$data = $data . " <td>".$seller["fname"]." ".$seller["lname"]."</td>"; 
					$data = $data . " <td>".$seller["phone"]."</td>";  
					
					$data = $data . " <td>".$row["orginal_price"]." S.R</td>"; 
					
					if($row["status"] != 0){ 
						$buyer = $userOb->getUser($row["sold_to_user"]);
						$data = $data . " <td>".$buyer["fname"]." ".$buyer["lname"]."</td>"; 
						$data = $data . " <td>".$buyer["phone"]."</td>"; 
					}else{
						$data = $data . " <td> - </td>"; 
						$data = $data . " <td> - </td>"; 
					}
				}
				$data = $data . "</tr>";
			}
			 
			return $data;
		}
		else
			return "<tr><td colspan=3>No tickets found</td></tr>";
	}
	
	

	function getOtherOfferedTickets($user_id){ 
		$sql = "select *, 
					resell_offers.price as new_price,  
					event.id as evid,
					order_details.id as order_details_id,
					resell_offers.id as resell_offers_id
				from resell_offers, order_details, event, tickets where  
					resell_offers.order_details_id =  order_details.order_id and   
					event.id = tickets.event_id AND
					order_details.ticket_id = tickets.id AND
					event_date >= now() and
					resell_offers.user_id != '$user_id' and
					status = 0
					order by resell_offers.id DESC ";	
		 
		$result = $this->db->executeQuery($sql);
		$data = "";
		
		if(gettype($result) == "object")
		{
			$sum = 0 ;
			while($row = $result->fetch_assoc()) 
			{ 
				$data = $data . "<tr>";
				$data = $data . " <td><a href='event_details.php?id=".$row["evid"]."' target='_blank'>".$row["title"]."</a></td>"; 
				$data = $data . " <td>".$row["event_date"]."</td>"; 
				$data = $data . " <td>One Ticket</td>";  
				$data = $data . " <td>".$row["new_price"]." S.R</td>"; 
				$rid = $row["resell_offers_id"];
				$data = $data . " <td><button onclick=\"addToCart('$rid')\">Add to Cart</button></td>"; 
				$data = $data . "</tr>";
			}
			 
			return $data;
		}
		else
			return "<tr><td colspan=3>No tickets found</td></tr>";
	}
	
	

	function ticketAlreadyOffered($user_id, $order_details_id){ 
		$sql = "select * from resell_offers where user_id = '$user_id' and order_details_id = '$order_details_id'";	
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
	
	 function addOffer($user_id, $order_details_id, $newPrice){
		$sql = "INSERT INTO  resell_offers (user_id, order_details_id, price, offer_dater, status, sold_to_user) 
			VALUES  ('$user_id' , '$order_details_id',  '$newPrice' , now(), '0' , '0')";  
		return $this->db->executeNonQuery($sql);
	 }
	 
	 
	 function getOfferDetails($resell_offer_id){
		 $sql = "select *, resell_offers.price as newPrice 
					from resell_offers, order_details where resell_offers.id = '$resell_offer_id' and order_id = order_details_id ";	
		$result = $this->db->executeQuery($sql);
		$data = array();
		
		if(gettype($result) == "object")
		{
			while($row = $result->fetch_assoc()) 
			{
				return $row;
			} 
		}
		
		return $data;
	 }
	 
	 function updateSellerQty($offer_id , $user_id){ 
		$sql = "update order_details set qty = qty - 1 where  id = (select order_details_id from resell_offers where id = '$offer_id')";    
		 
		if($this->db->executeNonQuery($sql)){ 
			$sql = "update resell_offers set status = '1' , sold_to_user = '$user_id' where id = '$offer_id' ";   
			return $this->db->executeNonQuery($sql);
		}
	 }
}

?>