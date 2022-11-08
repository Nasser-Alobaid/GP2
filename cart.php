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
  
$event = $_GET["event"] ?? "";
$msg = "";
switch($event){
	case "truncate":
		$cartOb->truncate($user_id);
		$msg = "Your cart has been truncated";
	break;
	case "remove":
		$ticket_id = $_GET["tid"] ?? 0;
		if($ticket_id > 0){ 
			if($cartOb->remove($user_id , $ticket_id)){
				$msg = "Ticket has been removed from your cart";
			}else{
				$msg = "Couldn't remove ticket from your cart";
			}
		}else{
			$msg = "Invalid ID";
		}
	break;
	case "payDone": 
		$totalPrice = $_GET["totalPrice"] ?? 0;
		if( $totalPrice > 0){ 
			if($orderOb->payDone( $user_id, $totalPrice, $cartOb)){
				$msg = "Your order submitted successfully";
			}else{
				$msg = "Couldn't place your order, please try again";
			}
		}else{
			$msg = "Invalid Request";
		}
	break;
}
?>
<style>
table {
	background-color: #fff;
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {background-color: #f2f2f2;}
</style>
  
			<br/>
			<br/>
			<br/>
			<br/>
				<!--===============================-->
				<!--== Events =============-->
				<!--===============================-->
			<section id="events" class="row">
				<div class="title-start col-md-4 col-md-offset-4"><h2>Cart Details</h2> 
				</div>
				<?php
				if($msg != ""):
				?>
				<div style="width:100%;margin-top:15px; color:#fff; text-align:center" ><p class="sub-text text-center btn-red" ><?=$msg?></p></div>
				
				<?php
				endif;
				?>
				<div class="top">
				</div>
				<div class="content"> 
						<div class="blog col-md-12">
							
							<h2 class="blog-head"></h2>
							<table class="table" width="100%">
								<tr>
									<th>Ticket ID</th>
									<th>Class Type</th>
									<th>Qty</th>
									<th>Ticket Price</th>
									<th>Total Price</th>
									<th>Ticket Sourse</th>
									<th>Delete</th>
								</tr>
							<?php
								echo  $cartOb->getCart($user_id);
							?>
							</table>
						  </div> 
				</div>
				   
			</section>
		 
<?php
include("template/footer.php");
?>