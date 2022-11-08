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

		<script>
			function addToCart(id){  
				window.location.href = "addToCart.php?src=seller&qty=1&resell_offer_id="+id;
			}
		</script>
			<br/>
			<br/>
			<br/>
			<br/>
				<!--===============================-->
				<!--== Events =============-->
				<!--===============================-->
			<section id="events" class="row">
				<div class="title-start col-md-4 col-md-offset-4"><h2>Tickets offer for resell</h2> 
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
									<th>Event</th>
									<th>Event Date</th> 
									<th>QTY</th> 
									<th>Class Type</th> 
									<th>Ticket Price</th>  
									<th>Offer Date</th>  
									<th>Add to Cart</th>  
								</tr>
							<?php
								echo  $orderOb->getOfferedTickets($user_id);
							?>
							</table>
						  </div> 
				</div>
				   
			</section>
		 
<?php
include("template/footer.php");
?>