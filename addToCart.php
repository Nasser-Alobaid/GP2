<?php
$private_page = true;
$showHeader = false;

include("cpnl/classes/DB.php");
include("cpnl/classes/Event.php");
include("cpnl/classes/Ticket.php");
include("cpnl/classes/Users.php");
include("cpnl/classes/Cart.php");
include("cpnl/classes/Order.php");


include("template/session.php");

$db = new DB(); 
if(isset($_SESSION["user"])){
	$u = $_SESSION["user"];
	$user_id = $u->getUserID();  
	$user = new Users($db );
	$userData = $user->getUser($user_id);
}



include("template/header.php");


$eventOb = new Event();
$ticketOb = new Ticket();
$cartOb = new Cart();
$orderOb = new Order($cartOb , $ticketOb );

$event_id = $_GET["event_id"] ?? 0;
$ticket_id = $_GET["tid"] ?? 0;
$resell_offer_id = $_GET["resell_offer_id"] ?? 0;
$qty = $_GET["qty"] ?? 0;

$isValidID = false;
$ticketsList = array();

if(is_numeric($event_id) && $event_id > 0){
	$isValidID = true;
	$event_details = $eventOb ->getEvent($event_id);
	$ticketsList = $ticketOb->getEventTickets($event_id);
} 
?>

  
			<br/>
			<br/>
			<br/>
			<br/>
				<!--===============================-->
				<!--== Events =============-->
				<!--===============================-->
			<section id="events" class="row">
				<div class="title-start col-md-4 col-md-offset-4"><h2>Info</h2> 
				</div>
				<div class="top">
				</div>
				<div class="content"> 
						<div class="blog col-md-12">
							<?php
								$allOk = false;
								$msg = "";
								$price = 0;
								if($resell_offer_id == 0){
									foreach($ticketsList as $ticket){
										if($ticket["id"] == $ticket_id)
										{
											if($qty >= $ticket["id"]){ 
												$allOk = true;
												$price = $ticket["price"];
											}else{
												$msg = "Quantity is not enough";
											}
										}
									}
								}else{ 
									$allOk = true;
								}
								if($allOk){
									
									if($resell_offer_id > 1){
										$data = $orderOb->getOfferDetails($resell_offer_id);
										if(sizeof($data) > 0 ){
											if($cartOb->addToCart( $user_id, $data["ticket_id"] , $data["newPrice"], 1 , $resell_offer_id)){ 
												$msg = "Ticket added to your cart successfully";
											}else{
												$msg = "Couldn't add this ticket to your cart";
											}
										}else{
											$msg = "Couldn't get offer details";
										}
									}else{
										if(!$cartOb->ticketExist($user_id, $ticket_id)){
											if($cartOb->addToCart( $user_id, $ticket_id , $price, $qty , $resell_offer_id)){
												//$ticketOb->updateTicketQTY( $ticket_id , $qty);
												$msg = "Ticket added to your cart successfully";
											}else{
												$msg = "Couldn't add this ticket to your cart";
											}
										}else{
											$msg = "Ticket already added to your cart";
										}
									}
									
								} 
							?>
							<h2 class="blog-head"><?=$msg?></h2>
							  
							<button onclick="goCart()"  class="button-info read-more">View Cart</button>
							<button onclick="goLink('index.php#events')"  class="button-info read-more">Continue Shopping</button>
						  </div> 
				</div>
				   
			</section>
		 
<?php
include("template/footer.php");
?>