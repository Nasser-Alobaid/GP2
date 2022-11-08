<?php
$private_page = true;
$showHeader = false;

include("cpnl/classes/DB.php");
include("cpnl/classes/Event.php");
include("cpnl/classes/Ticket.php");
include("cpnl/classes/Cart.php");
include("cpnl/classes/Users.php");
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

 
$ticketOb = new Ticket();
$cartOb = new Cart();
$orderOb = new Order($cartOb , $ticketOb );

$oid = $_GET["oid"] ?? 0;
$newPrice = $_GET["newPrice"] ?? 0; 

$isValidID = false;
$ticketsList = array();

if(is_numeric($oid) && $oid > 0){
	$isValidID = true; 
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
								$msg = "";
								$price = 0; 
								if(!$orderOb-> ticketAlreadyOffered($user_id, $oid)){
									if($orderOb->addOffer($user_id, $oid, $newPrice)){
										$msg = "Ticket added to offers list successfully";
									}else{
										$msg = "Couldn't add ticket in offers list";
									}
								}else{
									$msg = "Ticket already in offers list";
								}
							?>
							<h2 class="blog-head"><?=$msg?></h2>
							  
							<button onclick="goCart()"  class="button-info read-more">View My Tickets</button>
						  </div> 
				</div>
				   
			</section>
		 
<?php
include("template/footer.php");
?>