<?php
$private_page = false;
$showHeader = false;

include("cpnl/classes/DB.php");
include("cpnl/classes/Event.php");
include("cpnl/classes/Ticket.php");
include("cpnl/classes/Users.php");


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

$event_id = $_GET["id"] ?? 0;

$isValidID = false;
$ticketsList = array();

if(is_numeric($event_id) && $event_id > 0){
	$isValidID = true;
	$event_details = $eventOb ->getEvent($event_id);
	$ticketsList = $ticketOb->getEventTickets($event_id);
}
?>

 
		<script>
			function addToCart(id){
				var inputId = "#qty_"+id;
				var qty= $(inputId).val();
				window.location.href = "addToCart.php?tid="+id+"&qty="+qty+"&event_id="+<?=$event_id?>;
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
				<div class="title-start col-md-4 col-md-offset-4"><h2>Event Details</h2> 
				</div>
				<div class="top">
				</div>
				<div class="content"> 
						<div class="blog col-md-12">
							<h2 class="blog-head"><?=$event_details["title"]?></h2>
							<h3>
							Event on <span class="date-line"><?=$event_details["event_date"]?></span>
							</h3>
							</h3>
							<div style="width:50%; margin-left:auto; margin-right:auto;">
								<img class="blog-image" src="imgs/<?=$event_details["img"]?>" width="100%" alt="<?=$event_details["title"]?> Image"/>
							</div>
							
							<p class="firstpara"><?=$event_details["description"]?></p> 
 
							 
						  </div> 
				</div>
				   
			</section>
		
			<?php 
			if(sizeof($ticketsList)>0){
				?>
			<section id="prices" class="row">
				<div class="title-start events-menu col-md-4 col-md-offset-4">
				<h2>Pricing</h2>
				<p class="sub-text text-center">Details of our reasonable pricing</p>
				</div>
				<div class="col-md-12 visible-md visible-lg">
					<div class="wrap"> 
						<div class="pricing-table">
							<?php
									
								foreach($ticketsList as $ticket){
							?>
							<div class="plan">
								<h3 class="name">Class <?=$ticket["class_type"]?></h3>
								<h4 class="price"><?=$ticket["price"]?> S.R<span>/ticket</span></h4>

								<ul class="details">
									<li>Available <strong><?=$ticket["qty"]?> tickets</strong></li>
									<li><strong>Required Tickets</strong></li>
									<li>
										<input type="number" id="qty_<?=$ticket["id"]?>" name="name" value="1" 
													step="1" min="1" max="<?=$ticket["qty"]?>" style="border: 1px solid black">
									</li>
								</ul>

								<h5 class="order"><a href="#prices" onclick="addToCart(<?=$ticket["id"]?>)">Order Now</a></h5>
							</div><!--.plan-->
								<?php
								}
								?> 
 
						</div><!--.pricing-table-->
					</div><!--.wrap-->
				</div> 
			</section>
			<?php
			}
			?>
<?php
include("template/footer.php");
?>